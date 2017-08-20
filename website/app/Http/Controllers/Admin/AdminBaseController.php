<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Doctrine\ORM\EntityManager;

abstract class AdminBaseController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * @var string
     */
    protected $breadCrumbPattern = '/((http:\/\/[a-z.-]+\/admin)+\/([a-z]+))/';

    /**
     * @var string
     */
    protected $title = 'Admin';

    /**
     * @var EntityManager
     */
    protected $em;

    /**
     * AdminBaseController constructor.
     * @param EntityManager $entityManager
     */
    public function __construct(EntityManager $entityManager)
    {
        $this->em = $entityManager;
        $this->setRepos();
    }

    /**
     * @return mixed
     */
    abstract protected function setRepos();

    /**
     * @param string $view
     * @param array $data
     * @return \Illuminate\Contracts\View\View
     */
    public function renderView(string $view, array $data = [])
    {
        preg_match($this->breadCrumbPattern, url()->current(), $matches);

        if (isset($matches[3])) {
            $data['breadcrumb'] = ' / ' . ucfirst($matches[3]) ?? '';
        } else {
            $data['breadcrumb'] = ' / ';
        }

        if (isset($data['title'])) {
            $data['title'] = $this->title . ' - ' .  $data['title'];
        } else {
            $data['title'] = $this->title;
        }

        return \View::make($view, $data);
    }
}
