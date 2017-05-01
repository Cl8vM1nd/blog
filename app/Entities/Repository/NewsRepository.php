<?php
# CrEaTeD bY FaI8T IlYa      
# 2017

namespace App\Entities\Repository;

class NewsRepository extends EntityRepository
{

    /**
     * @param int $limit
     * @param int $offset
     * @return mixed
     */
    public function findAll(int $limit = null, int $offset = 0)
    {
        return $this->findBy(array(), array('id' => 'DESC'), $limit, $offset);
    }

    /**
     * @return mixed
     */
    public function findNewsCount()
    {
        return $this->createQueryBuilder('n')
            ->select('COUNT(n.id)')
            ->getQuery()
            ->getSingleScalarResult();
    }
}