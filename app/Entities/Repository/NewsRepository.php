<?php
# CrEaTeD bY FaI8T IlYa      
# 2017

namespace App\Entities\Repository;

use App\Entities\News;
use LaravelDoctrine\ORM\Pagination\PaginatesFromParams;

class NewsRepository extends EntityRepository
{
    use PaginatesFromParams;
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

    /**
     * @param int $limit
     * @param int $page
     * @return mixed
     */
    public function newsPaginate(int $limit = News::NEWS_ADMIN_COUNT_PER_PAGE, int $page = null)
    {
        $query = $this->createQueryBuilder('n')
            ->orderBy('n.id', 'DESC')
            ->getQuery();

        return $this->paginate($query, $limit, $page ?? 1);
    }

}