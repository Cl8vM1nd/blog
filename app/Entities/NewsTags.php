<?php

namespace App\Entities;

use Doctrine\ORM\Mapping as ORM;
use App\Entities\News;
use App\Entities\Tag;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * NewsTags
 *
 * @ORM\Table(name="news_tags", indexes={@ORM\Index(name="news_tags_news_id_foreign", columns={"news_id"}), @ORM\Index(name="news_tags_tag_id_foreign", columns={"tag_id"})})
 * @ORM\Entity(repositoryClass="App\Entities\Repository\NewsTagsRepository")
 */
class NewsTags
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var News
     *
     * @ORM\ManyToOne(targetEntity="App\Entities\News", inversedBy="tags")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="news_id", referencedColumnName="id")
     * })
     */
    private $news;

    /**
     * @var Tag
     *
     * @ORM\ManyToOne(targetEntity="Tag")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="tag_id", referencedColumnName="id")
     * })
     */
    private $tag;

    /**
     * NewsTags constructor.
     * @param \App\Entities\News $article
     * @param \App\Entities\Tag $tag
     */
    public function __construct(News $article, Tag $tag)
    {
        $this->setNews($article);
        $this->setTag($tag);
    }

    /**
     * @return News
     */
    public function getNews(): News
    {
        return $this->news;
    }

    /**
     * @param News $news
     */
    public function setNews(News $news)
    {
        $this->news = $news;
    }

    /**
     * @return Tag
     */
    public function getTag(): Tag
    {
        return $this->tag;
    }

    /**
     * @param Tag $tag
     */
    public function setTag(Tag $tag)
    {
        $this->tag = $tag;
    }
}

