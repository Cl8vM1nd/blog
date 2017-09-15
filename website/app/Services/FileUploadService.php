<?php
/**
 * Created by PhpStorm.
 * User: clevmind
 * Date: 14/09/2017
 * Time: 13:38
 */

namespace App\Services;
use Illuminate\Http\Request;

class FileUploadService
{
    const NEWS_IMAGE_PATH = 'news/images/';

    /**
     * @var CloudService $gc
     */
    protected $gc;

    function __construct(CloudService $cloudService)
    {
        $this->gc = $cloudService;
    }

    /**
     * @param Request $request
     * @param bool $ajax
     * @param string $path
     * @return \Illuminate\Http\JsonResponse|string
     * @throws \Exception
     */
    public function uploadImage(Request $request, string $path, $ajax = false)
    {
        $name = $request->file->getClientOriginalName();
        try {
            $request->file->storeAs($path, $name);
            $url = $this->gc->uploadNews($request->file->getPathName(), $path . $name, true);
            return $ajax ? response()->json(['location' => $url]) : $url;
        } catch(\Exception $e) {
            \Log::debug($e->getMessage());
            throw $e;
        }
    }

    /**
     * @param Request $request
     * @param string $oldName
     * @param string $path
     * @return \Illuminate\Http\JsonResponse|string
     */
    public function updateImage(Request $request, string $path, string $oldName)
    {
        $this->removeImage($oldName);
        return $this->uploadImage($request, $path);
    }

    /**
     * @param string $name
     * @return string
     */
    public function getImageUrl(string $name)
    {
        if ($this->gc->fileExist($name)) {
            return $this->gc->getPublicUrl($name);
        } else {
            return \URL::to('/') . '/' . $name;
        }
    }

    /**
     * @param $name
     * @throws \Exception
     */
    public function removeImage($name)
    {
        try {
            $this->gc->deleteFile($name);
            \Storage::delete($name);
        } catch (\Exception $e) {
            \Log::debug($e->getMessage());
            throw $e;
        }
    }
}