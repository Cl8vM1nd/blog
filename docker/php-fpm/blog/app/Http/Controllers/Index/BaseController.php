<?php
# CrEaTeD bY FaI8T IlYa      
# 2017  

namespace App\Http\Controllers\Index;

use App\Http\Controllers\Controller;
use Doctrine\ORM\EntityManager;

abstract class BaseController extends Controller
{
    protected $title = 'Cl8vM1nd Blog. All about DevOps Backend PHP TECH stuff. K8S and Docker containers';
    /**
     * @var EntityManager
     */
    protected $em;

    /**
     * BaseController constructor.
     * @param EntityManager $entityManager
     */
    public function __construct(EntityManager $entityManager)
    {
        $this->em = $entityManager;
        $this->initRepos();
    }

    /**
     * @return mixed
     */
    abstract protected function initRepos();

    /**
     * @param string $view
     * @param array $data
     * @return \Illuminate\Contracts\View\View
     */
    public function renderView(string $view, array $data = [])
    {
        if (isset($data['article']) && strpos($view, 'full') !== false) {
            $data['breadcrumb'] = "<a href='/'>Home</a> / <a href='" . route('news.show', $data['article']->getId()) . "'>{$data['article']->getTitle()}</a>";
        }

        if (!isset($data['title'])) {
            $data['title'] = $this->title;
        }

        return \View::make($view, $data);
    }
}