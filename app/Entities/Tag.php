<?php
namespace App\Entities;

use App\Entities\Traits\Dictionary;
use Doctrine\ORM\Mapping as ORM;

/**
 * Tags
 *
 * @ORM\Table(name="tag")
 * @ORM\Entity(repositoryClass="App\Entities\Repository\TagRepository")
 */
class Tag
{
    use Dictionary;
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=50, nullable=false)
     */
    protected $name;

    /**
     * @param string $name
     */
    public function setName(string $name)
    {
        $this->name = $name;
    }

    /**
     * Tags constructor.
     * @param string $name
     */
    public function __construct(string $name)
    {
        $this->setName($name);
    }
}

