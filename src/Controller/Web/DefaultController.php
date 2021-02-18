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
 * @Route("/", name="home")
 */
class DefaultController extends AbstractController
{
    /**
     * @Route("", name="_index", methods={"GET","POST"})
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        return $this->redirectToRoute('contact_post_contact');

    }

}
