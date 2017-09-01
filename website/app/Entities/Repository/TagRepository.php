<?php
# CrEaTeD bY FaI8T IlYa      
# 2017

namespace App\Entities\Repository;

class TagRepository extends EntityRepository
{
    /**
     * @param string $name
     *
     * @return mixed
     */
    public function findByName(string $name)
    {
        return $this->findOneBy(['name' => $name]);
    }

    /**
     * @param int $limit
     * @param int $offset
     * @return mixed
     */
    public function findAll(int $limit = null, int $offset = 0)
    {
        return $this->findBy(array(), array('id' => 'DESC'), $limit, $offset);
    }

}