<?php
# CrEaTeD bY FaI8T IlYa      
# 2017  
namespace App\Http\Controllers\Admin;

use App\Entities\News;
use App\Entities\Tag;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AdminController extends AdminBaseController
{
    protected $tagRepo;

    protected function setRepos()
    {
        $this->tagRepo = $this->em->getRepository(Tag::class);
    }

    /**
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        $news = $this->em->getRepository(News::class)->findAll(5);
        $tags = $this->tagService->getTagList();
        return $this->renderView('admin.index', [
            'news' => $news,
            'tags' => $tags
        ]);
    }

    /**
     * @return mixed
     */
    public function logOut()
    {
        \Auth::logout();
        return redirect()->route('admin::login');
    }
}
