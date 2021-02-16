<?php
/**
 * Created by PhpStorm.
 * User: johnjewelldino
 * Date: 2021-02-16
 * Time: 17:03
 */

namespace App\ApiBundle\Controller\V1;


use App\ApiBundle\Controller\AbstractApiController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @FOSRest\Prefix("/api/v1/contacts")
 * @FOSRest\NamePrefix("api_v1_contact_")
 */
class ContactController extends AbstractApiController
{
    /**
     * @Route ("/")
     * @param Request $request
     * @return Response
     */
    public function indexAction(Request $request): Response
    {
        return $this->respond("");
    }

    /**
     * @Route ("/")
     * @param Request $request
     * @return Response
     */
    public function createAction(Request $request): Response
    {
        $form = $this->buildForm(Contact::class);
        $form->handleRequest($request);


        if (!$form->isSubmitted() || !$form->isValid()) {
            $this->respond($form, Response::HTTP_BAD_REQUEST);
        }

        /** @var Contact $contact */
        $contact = $form->getData();

        return $this->respond($contact);
    }

    /**
     * @Route ("/{id}")
     * @param Request $request
     * @return Response
     */
    public function showAction(Request $request): Response
    {
        return $this->respond("");
    }

    /**
     * @Route ("/{id}")
     * @param Request $request
     * @return Response
     */
    public function updateAction(Request $request): Response
    {
        return $this->respond("");
    }

    /**
     * @Route ("/{id}")
     * @param Request $request
     * @return Response
     */
    public function deleteAction(Request $request): Response
    {
        return $this->respond(null);
    }

}