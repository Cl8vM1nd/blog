<?php

namespace App\Entities;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * News
 *
 * @ORM\Table(name="news")
 * @ORM\Entity(repositoryClass="App\Entities\Repository\NewsRepository")
 */
class News
{
    const NEWS_COUNT_PER_PAGE = 1;
    const NEWS_ADMIN_COUNT_PER_PAGE = 10;
    const OFFSET_NEWS_COOKIE_NAME = 'offset';
    const CACHE_NEWS_NAME = 'news';
    const CACHE_NEWS_AMOUNT = 'news_amount';
    const CACHE_NEWS_PERIOD = 180;
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="image", type="string", length=50, nullable=false)
     */
    private $image;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=255, nullable=false)
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="content", type="text", length=65535, nullable=false)
     */
    private $content;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_at", type="datetime", nullable=true)
     * @Gedmo\Timestampable(on="create")
     */
    private $createdAt;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="updated_at", type="datetime", nullable=true)
     * @Gedmo\Timestampable(on="update")
     */
    private $updatedAt;

    /**
     * @ORM\OneToMany(targetEntity="App\Entities\NewsTags", mappedBy="news", fetch="EAGER")
     */
    private $tags;

    /**
     * News constructor.
     * @param string $title
     * @param string $image
     * @param string $content
     */
    public function __construct(string $title, string $image, string $content)
    {
        $this->setTitle($title);
        $this->setImage($image);
        $this->setContent($content);
        $this->tags = new ArrayCollection();
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getImage(): string
    {
        return $this->image;
    }

    /**
     * @param string $image
     */
    public function setImage(string $image)
    {
        $this->image = $image;
    }

    /**
     * @param int $length
     * @return string
     */
    public function getTitle(int $length = null): string
    {
        if ($length) {
            return sprintf('%s...', substr($this->title, 0, $length));
        }
        return $this->title;
    }

    /**
     * @param string $title
     */
    public function setTitle(string $title)
    {
        $this->title = $title;
    }

    /**
     * @param int $length
     * @param array $tagsToRemove
     * @return string
     */
    public function getContent(int $length = null, array $tagsToRemove = []): string
    {
        if ($length) {
            return sprintf('%s...', substr($tagsToRemove ? $this->tagsRemove($tagsToRemove) : $this->content, 0, $length));
        }
        return $this->content;
    }

    /**
     * @param string $content
     */
    public function setContent(string $content)
    {
        $this->content = $content;
    }

    /**
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * @param \DateTime $createdAt
     */
    public function setCreatedAt(\DateTime $createdAt)
    {
        $this->createdAt = $createdAt;
    }

    /**
     * @return \DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * @param \DateTime $updatedAt
     */
    public function setUpdatedAt(\DateTime $updatedAt)
    {
        $this->updatedAt = $updatedAt;
    }

    /**
     * @return mixed
     */
    public function getTags()
    {
        return $this->tags;
    }

    /**
     * @param mixed $tags
     */
    public function setTags($tags)
    {
        $this->tags = $tags;
    }

    /**
     * @param array $tags
     * @return string
     */
    protected function tagsRemove(array $tags) : string
    {
        foreach ($tags as $tag) {
            switch ($tag) {
                case 'img' :
                    $this->content = preg_replace('/<img[a-zA-Z -_!@#$%^&*()_+=.,~]+\/>|<img[a-zA-Z -_!@#$%^&*()_+=.,~]+/', '', $this->content);
                    break;
                case 'all':
                    $this->content = strip_tags($this->content);
                    break;
            }
        }
        return $this->content;
    }
}

