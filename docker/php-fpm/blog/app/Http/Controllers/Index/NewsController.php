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
        $this->ajaxAuthService->generateHash();
        return $this->renderView('index.index');
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

        return $this->renderView('index.news.full', [
            'article' => $article,
            'title' => $article->getTitle()
        ]);
    }

    /**
     * If @var $offset = 0 it means script running first time
     * @param Request $request
     * @param int $amount
     * @param int $offset
     * @return mixed
     */
    public function getMoreNews(Request $request, int $offset = 0,  int $amount = News::NEWS_COUNT_PER_PAGE)
    {
        if (\Request::ajax()) {
            $this->verifyXSRFProtection();
            // If reach max news
            if ($offset >= $this->newsRepo->findNewsCount()) {
                return 'null';
            }

            if (!$offset) {
                // If we have news in cache retrieve it
                if ($view = \Cache::has(News::CACHE_NEWS_AMOUNT) && \Cache::get(NEWS::CACHE_NEWS_AMOUNT) == $amount) {
                    \Log::debug('RETURN CACHE');
                    return [
                        \Cache::get(NEWS::CACHE_NEWS_NAME),
                        $this->ajaxAuthService->generateHash(true)
                    ];
                }
            }

            $news = $this->newsRepo->findAll($amount, $offset);
            $view = $this->renderView('index.news.news-portion', ['news' => $news])->render();
            if (!$offset) {
                \Log::debug('SETTING CACHE');
                \Cache::put(News::CACHE_NEWS_AMOUNT, $amount, News::CACHE_NEWS_PERIOD);
                \Cache::put(News::CACHE_NEWS_NAME, json_encode($view), News::CACHE_NEWS_PERIOD);
            }
            return [
                json_encode($view),
                $this->ajaxAuthService->generateHash(true)
            ];
        } else {
            return abort(401, 'Bad Request');
        }
    }

    /**
     * If @var $offset = 0 it means script running first time
     * @param Request $request
     * @param int $tagId
     * @param int $offset
     * @param int $amount
     * @return array|string
     * // TODO:: CACHE
     */
    public function getNewsByTagMore(Request $request, int $tagId, int $offset = 0, int $amount = NEWS::NEWS_COUNT_PER_PAGE)
    {
        if (\Request::ajax()) {
            $this->verifyXSRFProtection();

            // If reach max news
            if ($offset >= count($this->newsTagsRepo->findBy(['tag' => $tagId]))) {
                return 'null';
            }

            $tags = $this->newsTagsRepo->findAll([
                'tag' => $tagId
            ], $amount, $offset);

            $news = [];
            foreach ($tags as $tag) {
                array_push($news, $tag->getNews());
            }

            $view = $this->renderView('index.news.news-portion', ['news' => $news])->render();
            return [
                json_encode($view),
                $this->ajaxAuthService->generateHash(true)
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