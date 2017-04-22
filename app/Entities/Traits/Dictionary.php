<?php

namespace App\Entities\Traits;

trait Dictionary
{
    /**
     * @var array
     */
    protected static $loaded = false;

    /**
     * Load dictionary into static variable.
     */
    protected static function load()
    {
        if (!static::$loaded) {
            \EntityManager::getRepository(static::class)->findAll();
        }
    }

    /**
     * @param int $id
     *
     * @return static
     */
    public static function find(int $id)
    {
        static::load();
        return \EntityManager::findById(static::class, $id);
    }

    /**
     * @param array $criteria
     *
     * @return static|null
     */
    public static function findOneBy(array $criteria)
    {
        return \EntityManager::getRepository(static::class)->findOneBy($criteria);
    }

    /**
     * @param $entity
     *
     * @return static
     */
    public static function convert($entity)
    {
        return ($entity instanceof static) ? $entity : static::find($entity);
    }

    /**
     * @param array $criteria
     *
     * @return array
     */
    public static function options(array $criteria = [])
    {
        $options = [];

        /** @var Dictionary $option */
        foreach (\EntityManager::getRepository(static::class)->findBy($criteria) as $option) {
            $options[$option->getId()] = $option->getName();
        }

        return $options;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->getName();
    }

    /**
    * @param int $id
    *
    * @return bool
    */
    public function is(int $id) : bool
    {
        return $this->getId() === $id;
    }

    /**
     * @param int $id
     *
     * @return bool
     */
    public function not(int $id) : bool
    {
        return $this->getId() !== $id;
    }
}
