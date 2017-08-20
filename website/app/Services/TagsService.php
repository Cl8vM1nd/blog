<?php
# CrEaTeD bY FaI8T IlYa      
# 2017  

namespace App\Services;

use App\Entities\News;
use App\Entities\NewsTags;
use App\Entities\Tag;
use App\Http\Controllers\Admin\NewsController;
use Doctrine\ORM\EntityManager;

class TagsService
{
    const TAG_CACHE_KEY = 'sidebar_tags_list';

    /**
     * @var EntityManager
     */
    protected $em;

    protected $tagRepo;

    protected $newsTagsRepo;

    /**
     * TagsService constructor.
     * @param EntityManager $entityManager
     */
    public function __construct(EntityManager $entityManager)
    {
        $this->em = $entityManager;
        $this->tagRepo = $this->em->getRepository(Tag::class);
        $this->newsTagsRepo = $this->em->getRepository(NewsTags::class);
    }

    /**
     * @param string $tags
     * @param News $article
     */
    public function attachTagsToArticle(News $article, string $tags)
    {
        $tagList = $this->createOrGetExisting($tags);
        foreach ($tagList as $tag) {
            if (!$this->newsTagsRepo->findOneBy([
                'tag'  => $tag->getId(),
                'news' => $article->getId()
            ])) {
                $newTag = new NewsTags($article, $tag);
                $this->em->persist($newTag);
                $this->em->flush();
            }
        }
        $this->calculateTagsCount();
    }

    /**
     * @param int $newsId
     * @param string $tag
     */
    public function detachTagFromArticle(int $newsId, string $tag)
    {
        $tagId = $this->tagRepo->findByName($tag)->getId();
        $this->em->remove($this->newsTagsRepo->findOneBy([
            'news' => $newsId,
            'tag' => $tagId
        ]));
        $this->em->flush();
    }

    /**
     * @param string $tags
     * @return array
     */
    protected function createOrGetExisting(string $tags): array
    {
        $tags = explode(',', $tags);
        $tagList = [];
        foreach ($tags as $tag) {
            $tag = ucfirst(strtolower($tag));
            if (!$newTag = $this->tagRepo->findByName($tag)) {
                $newTag = new Tag($tag);
                $this->em->persist($newTag);
                $this->em->flush();
            }
            array_push($tagList, $newTag);
        }
        return $tagList;
    }

    /**
     * @param News $news
     * @return string
     */
    public function tagsToString(News $news) : string
    {
        $tags = null;
        foreach ($arrayTags = $news->getTags()->toArray() as $tag) {
            if ($arrayTags[count($arrayTags) - 1]->getTag()->getId() != $tag->getTag()->getId()) {
                $tags .= $tag->getTag()->getName() . ',';
            } else {
                $tags .= $tag->getTag()->getName();
            }
        }
        return $tags;
    }

    /**
     * @param int $tagId
     * @return array
     * @throws \ErrorException
     */
    public function getNewsByTag(int $tagId) : array
    {
        $newsWithTags = $this->newsTagsRepo->findBy(['tag' => $tagId]);
        if (!$newsWithTags) {
            throw new \ErrorException('Tag not found.');
        }

        $news = [];
        foreach ($newsWithTags as $News) {
            array_push($news, $News->getNews());
        }
        return $news;
    }

    /**
     * @return array
     */
    public function calculateTagsCount() : array
    {
        $tags = [];
        $tagsArray = $this->tagRepo->findAll();
        foreach ($tagsArray as $tag) {
            if ($tagCount = $this->newsTagsRepo->findTagCount($tag->getId())) {
                array_push($tags, sprintf('<a href="' . route('news.search.byTag', $tag->getId()) . '">%s(%s)</a>', $tag->getName(), $tagCount));
            }
        }
        \Cache::forever(TagsService::TAG_CACHE_KEY, implode(',', $tags));
        return $tags;
    }

    /**
     * @return array
     */
    public function getTagList() : array
    {
        if (\Cache::has(TagsService::TAG_CACHE_KEY)) {
                return explode(',', \Cache::get(TagsService::TAG_CACHE_KEY));
        } else {
            \Log::debug('yes');
            return $this->calculateTagsCount();
        }
    }
}