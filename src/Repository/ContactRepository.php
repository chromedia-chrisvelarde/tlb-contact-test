<?php

namespace App\Repository;

use App\Entity\Contact;
use Doctrine\Persistence\ManagerRegistry;

class ContactRepository extends BaseRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Contact::class);
    }

}
