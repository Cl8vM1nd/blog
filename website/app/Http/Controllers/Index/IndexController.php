<?php
# CrEaTeD bY FaI8T IlYa      
# 2017  

namespace App\Http\Controllers\Index;

use App\Entities\News;

class IndexController extends BaseController
{
    protected $newsRepo;

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
}