<?php

namespace App\Service;

use App\Entity\Contact;
use App\Repository\ContactRepository;


class ContactManager extends BaseManager
{
    /**
     * @var ContactRepository
     */
    public $repository;

    /**
     * ContactManager constructor.
     *
     * @param ContactRepository $repository
     */
    public function __construct(ContactRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Create Contact
     * @param array $params
     * @return Contact
     * @throws \Exception
     */
    public function create(array $params)
    {
        $contact = $this->parse(new Contact(), $params);
        $contact->setCreatedAt(new \DateTime());
        $this->save($contact);

        return $contact;
    }

    /**
     * @param Contact  $client
     * @param array $params
     * @return Contact
     */
    private function parse(Contact $contact, array $params = null)
    {
        if (isset($params["lname"])) {
            $contact->setLname($params["lname"]);
        }

        if (isset($params["fname"])) {
            $contact->setFname($params["fname"]);
        }

        if (isset($params["email"])) {
            $contact->setEmail($params["email"]);
        }

        return $contact;
    }
}
