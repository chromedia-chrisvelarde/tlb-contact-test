<?php

namespace App\Repository;

use Doctrine\ORM\EntityManager;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * Class BaseRepository
 *
 */
abstract class BaseRepository extends ServiceEntityRepository
{
    /**
     * @return EntityManager
     */
    public function getEntityManager()
    {
        return parent::getEntityManager();
    }

    /**
     * @param $entity
     *
     * @return object
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function save($entity)
    {
        $this->getEntityManager()->persist($entity);
        $this->getEntityManager()->flush();

        return $entity;
    }

    /**
     * @param $entity
     *
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function delete($entity)
    {
        $this->getEntityManager()->remove($entity);
        $this->getEntityManager()->flush();
    }

    /**
     * @param $entity
     *
     * @return object
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function refresh($entity)
    {
        $this->getEntityManager()->refresh($entity);
        $this->getEntityManager()->flush();

        return $entity;
    }
}
