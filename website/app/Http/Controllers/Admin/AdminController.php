<?php
# CrEaTeD bY FaI8T IlYa      
# 2017  
namespace App\Http\Controllers\Admin;

use App\Entities\News;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AdminController extends AdminBaseController
{
    protected function setRepos()
    {
        // TODO: Implement setRepos() method.
    }

    /**
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        $news = $this->em->getRepository(News::class)->findAll(5);
        return $this->renderView('admin.index', ['news' => $news]);
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
