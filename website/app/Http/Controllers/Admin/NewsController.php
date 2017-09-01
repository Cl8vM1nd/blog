<?php
# CrEaTeD bY FaI8T IlYa
# 2017

namespace App\Http\Controllers\Admin;

use App\Entities\News;
use App\Services\CloudService;
use App\Services\TagsService;
use Illuminate\Http\Request;
use Doctrine\ORM\EntityManager;

class NewsController extends AdminBaseController
{
    protected $newsRepo;

    protected $tagsService;

    protected $cloudService;

    /**
     * NewsController constructor.
     * @param EntityManager $entityManager
     * @param TagsService $tagsService
     * @param CloudService $cloudService
     */
    public function __construct(EntityManager $entityManager, TagsService $tagsService, CloudService $cloudService)
    {
        $this->em = $entityManager;
        $this->tagsService = $tagsService;
        $this->cloudService = $cloudService;
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
            'image'      => 'image|required',
            'imageTitle' => 'string|required',
            'content'    => 'string|required',
            'tags'       => 'required|regex:/[a-zA-Z-_., ]+/'
        ]);


        $imageName = $request->input('imageTitle') . '.' . $request->image->extension();
        $request->file('image')->storeAs(News::LOCAL_PATH, $imageName);
        #$this->cloudService->upload($request->image->getPathName(), $imageName);

        $article = new News($request->input('title'), $imageName, $request->input('content'));
        $this->em->persist($article);
        $this->em->flush();

        $this->tagsService->attachTagsToArticle($article, $request->input('tags'));

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
            'image'      => 'image',
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

        if ($request->input('image')) {
            $imageName = $request->input('imageTitle') . '.' . $request->image->extension();
            $request->file('image')->storeAs(News::LOCAL_PATH, $imageName);
           # $this->cloudService->upload($request->image->getPathName(), $imageName);
        }

        $article->setTitle($request->input('title'));
        $article->setContent($request->input('content'));
        $article->setImage($request->input('imageTitle'));

        $this->em->flush();

        $this->tagsService->attachTagsToArticle($article, $request->input('tags'));

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

        $this->em->remove($news);
        $this->em->flush();

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
        return response()->json(['location' => $this->cloudService->uploadNews($request->file->getPathName(), $request->file->getClientOriginalName(), true)]);
    }
}
