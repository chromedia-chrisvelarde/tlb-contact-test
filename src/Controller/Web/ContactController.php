<?php

namespace App\Controller\Web;

use App\Entity\Contact;
use App\Form\Type\ContactType;
use App\Service\ContactManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/contact", name="contact")
 */
class ContactController extends AbstractController
{

    /**
     * @var ContactManager $contactManager
     */
    private $contactManager;

    /**
     * @param ContactManager $contactManager
     * @param FormInterface $formFactory
     */
    public function __construct(ContactManager $contactManager)
    {
        $this->contactManager = $contactManager;
    }

    /**
     * @Route("", name="post_contact", methods={"POST"})
     * @param Request $request
     */
    public function index(Request $request): Response
    {
//        $contact = $this->contactManager->create(
//            [
//                'lname' => 'llano',
//                'fname' => 'joel',
//                'email' => 'joel.llano@chromedia.com'
//            ]
//        );


        $form = $this->createForm(ContactType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var Contact $contact */
            $contact = new Contact();
            $validContact = $form->getData();
        }

        return new Response();

    }

}
