<?php
/**
 * Created by PhpStorm.
 * User: johnjewelldino
 * Date: 2021-02-16
 * Time: 17:03
 */

namespace App\ApiBundle\Controller\V1;

use App\ApiBundle\Controller\AbstractApiController;
use App\Entity\Contact;
use App\Form\Type\ContactType;
use App\Repository\ContactRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\Annotations\Route;

class ContactController extends AbstractApiController
{
    /**
     * @Route ("/", name="list", methods={"GET"})
     * @return Response
     */
    public function indexAction(): Response
    {
        /** @var ContactRepository $repository */
        $repository = $this->getDoctrine()->getRepository(Contact::class);
        /** @var Contact[] $allContacts */
        $allContacts = $repository->findAll();

        return $this->respond($allContacts);
    }

    /**
     * @Route ("/", name="create", methods={"POST"})
     * @param Request $request
     * @return Response
     * @throws \Exception
     */
    public function createAction(Request $request): Response
    {
        /** @var ContactRepository $repository */
        $repository = $this->getDoctrine()->getRepository(Contact::class);

        $form = $this->buildForm(ContactType::class);
        $form->handleRequest($request);

        if (!$form->isSubmitted() || !$form->isValid()) {
            return $this->respond($form, Response::HTTP_BAD_REQUEST);
        }

        /** @var Contact $contact */
        $contact = new Contact();
        $validContact = $form->getData();

        if (!empty($validContact['email'])) {
            $contact->setEmail($validContact['email']);
        }
        if (!empty($validContact['fname'])) {
            $contact->setFname($validContact['fname']);
        }
        if (!empty($validContact['lname'])) {
            $contact->setLname($validContact['lname']);
        }
        $contact->setCreateAt(new \DateTime());
        $repository->saveContact($contact);

        return $this->respond($contact);
    }

    /**
     * @Route ("/{id}", name="show", methods={"GET"})
     * @param int $id
     * @return Response
     */
    public function showAction($id): Response
    {
        /** @var ContactRepository $repository */
        $repository = $this->getDoctrine()->getRepository(Contact::class);
        /** @var Contact $contact */
        $contact = $repository->findOneBy(['id' => $id]);

        if (null === $contact) {
            return $this->respond("Contact with ID: $id not found.", Response::HTTP_BAD_REQUEST);
        }

        return $this->respond($contact);
    }

    /**
     * @Route ("/{id}", name="update", methods={"PATCH, PUT"})
     * @param int $id
     * @param Request $request
     * @return Response
     */
    public function updateAction($id, Request $request): Response
    {
        /** @var ContactRepository $repository */
        $repository = $this->getDoctrine()->getRepository(Contact::class);
        /** @var Contact $contact */
        $contact = $repository->findOneBy(['id' => $id]);

        $form = $this->buildForm(ContactType::class);
        $form->handleRequest($request);

        if (!$form->isSubmitted() || !$form->isValid()) {
            return $this->respond($form, Response::HTTP_BAD_REQUEST);
        }

        $validContact = $form->getData();

        if (!empty($validContact['email'])) {
            $contact->setEmail($validContact['email']);
        }
        if (!empty($validContact['fname'])) {
            $contact->setFname($validContact['fname']);
        }
        if (!empty($validContact['lname'])) {
            $contact->setLname($validContact['lname']);
        }

        $repository->saveContact($contact);

        return $this->respond($contact);
    }

    /**
     * @Route ("/{id}", name="delete", methods={"DELETE"})
     * @param int $id
     * @return Response
     */
    public function deleteAction($id): Response
    {
        /** @var ContactRepository $repository */
        $repository = $this->getDoctrine()->getRepository(Contact::class);
        /** @var Contact $contact */
        $contact = $repository->findOneBy(['id' => $id]);

        $repository->deleteContact($contact);

        return $this->respond(null, Response::HTTP_NO_CONTENT);
    }

}
