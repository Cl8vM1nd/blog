<?php
# CrEaTeD bY FaI8T IlYa      
# 2017  

namespace App\Http\Controllers\Index;

use App\Entities\News;
use App\Services\AjaxAuthService;
use App\Services\TagsService;
use Doctrine\ORM\EntityManager;
use Illuminate\Http\Request;

class NewsController extends BaseController
{
    protected $newsRepo;

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
    }

    /**
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        $news = $this->newsRepo->findAll(News::NEWS_COUNT_PER_PAGE);
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
       $news = $this->tagService->getNewsByTag($tagId);

       return $this->renderView('index.index', ['news' => $news]);
    }


    /**
     * @param Request $request
     * @param int $offset
     * @return mixed
     */
    public function getMoreNews(Request $request, int $offset)
    {
        if (\Request::ajax()) {
            if(\Cookie::get('XSRF-TOKEN') !== csrf_token()) {
                return abort(401, 'Bad Request');
            }

            // If reach max news
            if ($offset > $this->newsRepo->findNewsCount()) {
                return 'null';
            }

            // Check if auth hash is ok
            if(!$this->ajaxAuthService->checkHash($request->header('Auth'))) {
                return abort(401, 'Bad Request');
            }

            $news = $this->newsRepo->findAll(News::NEWS_COUNT_PER_PAGE, $offset);

            $view = $this->renderView('index.news.news-portion', [
                'news' => $news,
                'at'   => $this->ajaxAuthService->generateHash(true)
            ])->render();

            return [$view, $this->ajaxAuthService->generateHash(true)];
        } else {
            return abort(401, 'Bad Request');
        }
    }
}