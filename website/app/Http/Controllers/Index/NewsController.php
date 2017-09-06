<?php
# CrEaTeD bY FaI8T IlYa      
# 2017  

namespace App\Http\Controllers\Index;

use App\Entities\News;
use App\Entities\NewsTags;
use App\Services\AjaxAuthService;
use App\Services\TagsService;
use Doctrine\ORM\EntityManager;
use Illuminate\Http\Request;
use Cookie;

class NewsController extends BaseController
{
    protected $newsRepo;

    protected $newsTagsRepo;

    protected $tagService;

    protected $ajaxAuthService;


    /**
     * BaseController constructor.
     * @param EntityManager $entityManager
     * @param TagsService $tagsService
     * @param AjaxAuthService $ajaxAuthService
     */
    public function __construct(EntityManager $entityManager, TagsService $tagsService, AjaxAuthService $ajaxAuthService)
    {
        $this->em = $entityManager;
        $this->tagService = $tagsService;
        $this->ajaxAuthService = $ajaxAuthService;
        $this->initRepos();
    }

    protected function initRepos()
    {
       $this->newsRepo = $this->em->getRepository(News::class);
       $this->newsTagsRepo = $this->em->getRepository(NewsTags::class);
    }

    /**
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        if(isset($_COOKIE['OFFSET'])) {
            $news = $this->newsRepo->findAll((int)$_COOKIE['OFFSET']);
        } else {
            $news = $this->newsRepo->findAll(News::NEWS_COUNT_PER_PAGE);
        }

        $this->ajaxAuthService->generateHash();
        return $this->renderView('index.index', ['news' => $news]);
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Contracts\View\View
     */
    public function show(Request $request, $id)
    {
        if (!$article = $this->newsRepo->find($id)) {
            abort(404, 'Entity not found.');
        }

       // $this->ajaxAuthService->generateHash();

        return $this->renderView('index.news.full', [
            'article' => $article,
            'title' => $article->getTitle()
        ]);
    }

    /**
     * @param int $tagId
     * @return \Illuminate\Contracts\View\View
     */
    public function getNewsByTag(int $tagId)
    {
       $tags = $this->newsTagsRepo->findAll(['tag' => $tagId], News::NEWS_COUNT_PER_PAGE);
       $news = [];
       foreach ($tags as $tag) {
           array_push($news, $tag->getNews());
       }

       $this->ajaxAuthService->generateHash();
       return $this->renderView('index.index', ['news' => $news]);
    }


    /**
     * If @var $offset = 0 it means script running first time
     * @param Request $request
     * @param int $tagId
     * @param int $offset
     * @return array|string
     */
    public function getNewsByTagMore(Request $request, int $tagId, int $offset)
    {
        if (\Request::ajax()) {
            $this->verifyXSRFProtection();

            // If reach max news
            if ($offset > count($this->newsTagsRepo->findBy(['tag' => $tagId]))) {
                return 'null';
            }

            $tags = $this->newsTagsRepo->findAll([
                'tag' => $tagId
            ], News::NEWS_COUNT_PER_PAGE, !$offset ? News::NEWS_COUNT_PER_PAGE : $offset);

            $news = [];
            foreach ($tags as $tag) {
                array_push($news, $tag->getNews());
            }

            $view = $this->renderView('index.news.news-portion', ['news' => $news])->render();
            return [
                $view,
                $this->ajaxAuthService->generateHash(true),
                !$offset ? News::NEWS_COUNT_PER_PAGE + News::NEWS_COUNT_PER_PAGE : News::NEWS_COUNT_PER_PAGE
            ];
        } else {
            return abort(401, 'Bad Request');
        }
    }


    /**
     * If @var $offset = 0 it means script running first time
     * @param Request $request
     * @param int $offset
     * @return mixed
     */
    public function getMoreNews(Request $request, int $offset)
    {
        if (\Request::ajax()) {
            $this->verifyXSRFProtection();
            // If reach max news
            if ($offset > $this->newsRepo->findNewsCount()) {
                return 'null';
            }

            $news = $this->newsRepo->findAll(News::NEWS_COUNT_PER_PAGE, !$offset ? News::NEWS_COUNT_PER_PAGE : $offset);
            $view = $this->renderView('index.news.news-portion', ['news' => $news])->render();
            return [
                $view,
                $this->ajaxAuthService->generateHash(true),
                !$offset ? News::NEWS_COUNT_PER_PAGE + News::NEWS_COUNT_PER_PAGE : News::NEWS_COUNT_PER_PAGE
            ];
        } else {
            return abort(401, 'Bad Request');
        }
    }

    protected function verifyXSRFProtection()
    {
        if(\Cookie::get('XSRF-TOKEN') !== csrf_token()) {
            return abort(401, 'Bad Request');
        }
    }
}