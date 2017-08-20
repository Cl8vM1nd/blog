<?php
namespace App\Entities\Repository;

use App\Entities\Exception\EntityNotFound;

use Doctrine\ORM\EntityRepository as DefaultEntityRepository;

class EntityRepository extends DefaultEntityRepository
{

    /**
     * @return \Doctrine\ORM\EntityManager
     */
    public function getEntityManager()
    {
        return parent::getEntityManager();
    }

    /**
     * @param $id
     *
     * @return object
     * @throws EntityNotFound
     */
    public function findById($id)
    {
        if ( ! ($entity = $this->find($id))) {
            throw new EntityNotFound($this->getClassName(), ['id' => $id]);
        }
        
        return $entity;
    }

    /**
     * @param object|array|int $entity
     *
     * @return object
     */
    public function convert($entity)
    {
        return is_object($entity) && get_class($entity) === $this->getClassName() ? $entity : $this->findById($entity);
    }

    /**
     * @param string $anchor
     * @return mixed
     */
    public function createBlogQueryBuilder(string $anchor)
    {
        $qb = $this->createQueryBuilder($anchor);
        $qb->setResultCacheLifetime(3600);
        return $qb;
    }
}
