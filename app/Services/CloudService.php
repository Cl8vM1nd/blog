<?php
# CrEaTeD bY FaI8T IlYa      
# 2017
namespace App\Services;

use \Illuminate\Contracts\Filesystem\Filesystem as Visibility;

class CloudService
{
    /**
     * @var \Illuminate\Filesystem\FilesystemAdapter
     */
    protected $gc;

    /**
     * @var string
     */
    protected $baseUrl = 'https://storage.googleapis.com/clevmind-blog/';

    /**
     * CloudService constructor.
     */
    public function __construct()
    {
        $this->gc = \Storage::cloud();
    }

    /**
     * @param string $path
     * @param string $name
     * @param bool $override
     * @param $visibility
     * @return bool
     * @throws \ErrorException
     */
    public function upload(string $path, string $name, bool $override = true, $visibility = Visibility::VISIBILITY_PUBLIC)
    {
        if (file_exists($path)) {
            $file = file_get_contents($path);
            if ($file) {
                if (($this->gc->exists($name) && $override) || (!$this->gc->exists($name))) {
                    if (!$this->gc->put($name, $file, $visibility)) {
                        throw new \ErrorException('File upload error.', 500);
                    }
                    return true;
                } else {
                    throw new \ErrorException('File exist.');
                }
            } else {
                throw new \ErrorException('Bad file.');
            }
        } else {
            throw new \ErrorException('File not found.');
        }
    }

    /**
     * @param string $name
     * @return string
     */
    public function getPublicUrl(string $name)
    {
        return $this->baseUrl . $name;
    }

    /**
     * @param string $name
     * @return mixed
     * @throws \ErrorException
     */
    public function getFile(string $name)
    {
        if ($this->gc->exists($name)) {
            return $this->gc->get($name);
        } else {
            throw new \ErrorException('File not found.');
        }
    }

    /**
     * @param string $name
     * @return mixed
     */
    public function getNameWithoutExtension(string $name)
    {
        return preg_split('/(.[jpg]{3}|.[png]{3}|.[jpeg]{4}|.[gif]{3})/', $name)[0];
    }
}