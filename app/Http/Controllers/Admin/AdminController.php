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
        return $this->renderView('admin.index');
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
