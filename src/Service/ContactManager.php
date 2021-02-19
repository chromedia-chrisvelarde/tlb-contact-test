<?php

namespace App\Service;

use App\Entity\Contact;
use App\Repository\ContactRepository;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Mime\Address;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use App\Exception\MailerException;

class ContactManager extends BaseManager
{

    /**
     * @var MailerInterface $mailer
     */
    private $mailer;

    /**
     * @var ContactRepository
     */
    public $repository;

    /**
     * ContactManager constructor.
     *
     * @param ContactRepository $repository
     * @param MailerInterface $mailer
     */
    public function __construct(ContactRepository $repository, MailerInterface $mailer)
    {
        $this->repository = $repository;
        $this->mailer = $mailer;
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

        if (isset($params["message"])) {
            $contact->setMessage($params["message"]);
        }

        return $contact;
    }

    /**
     * Get All Contacts
     *
     * @return Contact[]
     */
    public function getAll()
    {
        return $this->repository->findAll();
    }

    /**
     * Send Email
     * @param array $params
     *
     * @throws MailerException
     * @return ContactManager
     */
    public function sendEmail(array $params) : ContactManager
    {
        $admin = (new TemplatedEmail())
            ->from(new Address($params['email']))
            ->to(new Address($_ENV['EMAIL_CONTACT_TO']))
            ->subject("Newly Submitted Contact")
            ->htmlTemplate("emails/admin_copy_contact.html.twig")
            ->context([
                'contact' => $params,
            ])
        ;

        $user = (new TemplatedEmail())
            ->from(new Address($_ENV['EMAIL_CONTACT_TO']))
            ->to(new Address($params['email']))
            ->subject("Newly Submitted Contact - User's Copy")
            ->htmlTemplate("emails/user_copy_contact.html.twig")
            ->context([
                'contact' => $params,
            ])
        ;

        try {
            $this->mailer->send($admin);
            $this->mailer->send($user);
        } catch (TransportExceptionInterface $e) {
            throw MailerException::transportFails($e->getCode());
        }

        return $this;
    }

}
