<?php
# CrEaTeD bY FaI8T IlYa      
# 2017

namespace App\Entities\Repository;

class NewsTagsRepository extends EntityRepository
{
    /**
     * @param int $tagId
     * @return mixed
     */
    public function findTagCount(int $tagId)
    {
        return $this->createQueryBuilder('nt')
            ->select('COUNT(nt.id)')
            ->where('nt.tag = :tagId')
            ->setParameter('tagId', $tagId)
            ->getQuery()
            ->getSingleScalarResult();
    }
}