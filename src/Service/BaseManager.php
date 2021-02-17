<?php

namespace App\Service;

use App\Repository\BaseRepository;

/**
 * Class BaseManager
 *
 */
abstract class BaseManager
{
    /**
     * @var BaseRepository
     */
    protected $repository;

    /**
     * @param $object
     *
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function save($object)
    {
        $this->repository->save($object);
    }

    /**
     * @param $object
     *
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function remove($object)
    {
        $this->repository->delete($object);
    }
}
