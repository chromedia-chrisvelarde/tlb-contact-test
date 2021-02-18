<?php

namespace App\Controller\Web;

use App\Entity\Contact;
use App\Form\Type\ContactType;
use App\Service\ContactManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Exception\MailerException;

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
     */
    public function __construct(ContactManager $contactManager)
    {
        $this->contactManager = $contactManager;
    }

    /**
     * @Route("", name="_post_contact", methods={"GET","POST"})
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $form = $this->createForm(ContactType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            if ($form->isValid()){
                $formData = $form->getData();
                $contact = null;
                try {
                    $contact = $this->contactManager->sendEmail($formData)->create($formData);
                } catch (MailerException $e) {
                    $this->addFlash('error', "Error Sending Email: {$e->getMessage()}");
                }

                if (null != $contact) {
                    $this->addFlash('success', "Contact Sent!");
                    return $this->redirectToRoute('contact_post_contact');
                }

            }
        }

        return $this->render('contact/index.html.twig',
            [
            'form' => $form->createView()
            ]
        );

    }

}
