<?php
# CrEaTeD bY FaI8T IlYa      
# 2017  

namespace App\Http\Controllers\Index;

use App\Entities\News;
use App\Services\TagsService;
use Doctrine\ORM\EntityManager;
use Illuminate\Http\Request;

class NewsController extends BaseController
{
    protected $newsRepo;

    protected $tagService;

    /**
     * BaseController constructor.
     * @param EntityManager $entityManager
     * @param TagsService $tagsService
     */
    public function __construct(EntityManager $entityManager, TagsService $tagsService)
    {
        $this->em = $entityManager;
        $this->tagService = $tagsService;
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
        $news = $this->newsRepo->findAll();
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
}