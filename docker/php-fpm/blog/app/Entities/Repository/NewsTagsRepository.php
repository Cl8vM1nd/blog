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

    /**
     * @param array|null $condition
     * @param int|null $limit
     * @param int $offset
     * @return array
     */
    public function findAll(array $condition = null, int $limit = null, int $offset = 0)
    {
        return $this->findBy($condition, array('id' => 'DESC'), $limit, $offset);
    }
}