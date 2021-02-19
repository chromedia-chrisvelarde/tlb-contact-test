<?php
/**
 * Created by PhpStorm.
 * User: johnjewelldino
 * Date: 2021-02-16
 * Time: 17:03
 */

namespace App\Controller\Api\V1;

use App\Service\ContactManager;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use FOS\RestBundle\Controller\Annotations as FOSRest;
use Symfony\Component\Routing\Annotation\Route;
use FOS\RestBundle\Request\ParamFetcher;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Nelmio\ApiDocBundle\Annotation\Model;
use Nelmio\ApiDocBundle\Annotation\Security;
use OpenApi\Annotations as OA;

/**
 * @FOSRest\Route("/api/v1/contact", name="contact")
 */
class ContactController extends AbstractFOSRestController
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
     * Get Collection of Contacts
     *
     * ### Sample Response ###
     * <pre><code>{
     *      "contacts": [
     *          {
     *              "id": 1,
     *              "lname": "Lorem Ipsum",
     *              "fname": "Lorem Ipsum",
     *              "email": "email@example.com",
     *              "created_at": "2021-02-17T23:22:03+08:00"
     *          },
     *          {},
     *          {}
     *          .
     *          .
     *          .
     *      ]
     *  }</code></pre>
     *
     * @OA\Tag(name="Contact")
     * @Security(name="Bearer")
     *
     * @OA\Response(
     *     response=200,
     *     description="Returns the Collection of Contact",
     *     @OA\JsonContent(
     *        type="array",
     *        @OA\Items(ref=@Model(type=Contact::class, groups={"full"}))
     *     )
     * )
     *
     *
     * @FOSRest\Route("", name="get_contacts", methods={"GET"})
     * @FOSRest\View(serializerGroups={"Contact"})
     *
     * @return Response
     *
     */
    public function cgetContacts()
    {
        return $this->handleView($this->view([ 'contacts' => $this->contactManager->getAll()], Response::HTTP_OK));
    }


}
