<?php
# CrEaTeD bY FaI8T IlYa
# 2017

namespace App\Http\Controllers\Admin;

use App\Entities\News;
use App\Services\CloudService;
use App\Services\FileUploadService;
use App\Services\TagsService;
use Illuminate\Http\Request;
use Doctrine\ORM\EntityManager;

class NewsController extends AdminBaseController
{
    protected $newsRepo;

    /**
     * @var TagsService $tagsService
     */
    protected $tagsService;

    /**
     * @var CloudService $cloudService
     */
    protected $cloudService;

    /**
     * @var FileUploadService $fileUploadService
     */
    protected $fileUploadService;

    /**
     * NewsController constructor.
     * @param EntityManager $entityManager
     * @param TagsService $tagsService
     * @param CloudService $cloudService
     * @param fileUploadService $fileUploadService
     */
    // TODO: Remove cloudService
    public function __construct(
        EntityManager $entityManager,
        TagsService $tagsService,
        CloudService $cloudService,
        FileUploadService $fileUploadService)
    {
        $this->em = $entityManager;
        $this->tagsService = $tagsService;
        $this->cloudService = $cloudService;
        $this->fileUploadService = $fileUploadService;
        $this->setRepos();
    }

    /**
     * @return \Doctrine\ORM\EntityRepository
     */
    protected function setRepos()
    {
        $this->newsRepo = $this->em->getRepository(News::class);
    }


    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\View
     */
    public function getNews(Request $request)
    {
        return $this->renderView('admin.news.index', [
            'title' => 'News',
            'news'  => $this->newsRepo->newsPaginate(News::NEWS_ADMIN_COUNT_PER_PAGE, $request->input('page'))
        ]);
    }

    /**
     * @return \Illuminate\Contracts\View\View
     */
    public function addNews()
    {
        return $this->renderView('admin.news.add-or-edit', [
            'title'  => 'Add news',
            'action' => 'admin::news.save'
        ]);
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function saveNews(Request $request)
    {
        $this->validate($request, [
            'title'      => 'string|required',
            'file'       => 'image|required',
            'imageTitle' => 'string|required',
            'content'    => 'string|required',
            'tags'       => 'required|regex:/[a-zA-Z-_., ]+/'
        ]);

        $this->fileUploadService->uploadImage($request, FileUploadService::NEWS_IMAGE_PATH);

        $article = new News($request->input('title'), FileUploadService::NEWS_IMAGE_PATH . $request->file->getClientOriginalName(), $request->input('content'));
        $this->em->persist($article);
        $this->em->flush();

        $this->tagsService->attachTagsToArticle($article, $request->input('tags'));

        /* Clean cache for dynamic news */
        \Cache::flush();

        return redirect()->route('admin::news.index');
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function updateNews(Request $request)
    {
        $this->validate($request, [
            'id'         => 'required|integer',
            'file'       => 'image',
            'title'      => 'required',
            'imageTitle' => 'string|required',
            'content'    => 'required',
            'tags'       => 'required|regex:/[a-zA-Z-_., ]+/'
        ]);

        /** @var News $article */
        $article = $this->newsRepo->find($request->input('id'));
        if (!$article) {
            abort(404, 'Not found.');
        }

        if ($request->file) {
            $this->fileUploadService->updateImage($request, FileUploadService::NEWS_IMAGE_PATH, $article->getImage());
            $article->setImage(FileUploadService::NEWS_IMAGE_PATH . $request->file->getClientOriginalName());
        }

        $article->setTitle($request->input('title'));
        $article->setContent($request->input('content'));

        $this->em->flush();

        $this->tagsService->attachTagsToArticle($article, $request->input('tags'));

        /* Clean cache for dynamic news */
        \Cache::flush();

        return redirect()->route('admin::news.index');
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Contracts\View\View
     */
    public function editNews(Request $request, $id)
    {
        /** @var News $news */
        $news = $this->newsRepo->find($id);
        if (!$news) {
            abort(404, 'Not found.');
        }

        return $this->renderView('admin.news.add-or-edit', [
            'title'       => 'Edit news',
            'action'      => 'admin::news.update',
            'nId'         => $news->getId(),
            'nTitle'      => $news->getTitle(),
            'nTags'       => $this->tagsService->tagsToString($news),
            'nImageTitle' => $news->getImage(),
            'nContent'    => trim($news->getContent()),
            'nButton'     => 'Update News'
        ]);
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Contracts\View\View
     */
    public function viewNews(Request $request, $id)
    {
        /** @var News $news */
        $news = $this->newsRepo->find($id);
        if (!$news) {
            abort(404, 'Not found.');
        }

        return $this->renderView('admin.news.view', [
            'title'    => 'Edit news',
            'nId'      => $news->getId(),
            'nTitle'   => $news->getTitle(),
            'nContent' => trim($news->getContent()),
        ]);
    }

    /**
     * @param Request $request
     * @param $id
     * @return mixed
     */
    public function deleteNews(Request $request, $id)
    {
        /** @var News $news */
        $news = $this->newsRepo->find($id);
        if (!$news) {
            abort(404, 'Not found.');
        }

        $this->fileUploadService->removeImage($news->getImage());

        $this->em->remove($news);
        $this->em->flush();
        $this->tagsService->calculateTagsCount();

        /* Clean cache for dynamic news */
        \Cache::flush();

        return redirect()->route('admin::news.index');
    }

    /**
     * @param Request $request
     * @param $id
     */
    public function detachTagFromArticle(Request $request, $id)
    {
        $this->tagsService->detachTagFromArticle($id, $request->input('tag'));
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function uploadImage(Request $request)
    {
       return $this->fileUploadService->uploadImage($request, FileUploadService::NEWS_IMAGE_PATH, true);
    }
}
