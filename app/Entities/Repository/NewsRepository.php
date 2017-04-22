<?php
# CrEaTeD bY FaI8T IlYa      
# 2017

namespace App\Entities\Repository;

class NewsRepository extends EntityRepository
{
    /**
     * @return mixed
     */
    public function findAll()
    {
        return $this->findBy(array(), array('id' => 'DESC'));
    }
}