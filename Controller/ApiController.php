<?php
namespace Opositatest\InterestUserBundle\Controller;

use FOS\RestBundle\Controller\FOSRestController;
use Opositatest\InterestUserBundle\Entity\Interest;
use Symfony\Component\HttpFoundation\Request;
use Swagger\Annotations as SWG;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Nelmio\ApiDocBundle\Annotation\Operation;

class ApiController extends FOSRestController {

    /**
     * Add interest to User
     *
     * @Route("/api/interestUser/{interestId}", name="Add interest to User")
     * @Method({"POST"})
     * @Operation(
     *     tags={"Interest"},
     *     summary="Add interest to User",
     *     consumes={"multipart/form-data"},
     *     produces={"application/json"},
     *     @SWG\Parameter(
     *         name="followMode",
     *         in="formData",
     *         description="",
     *         required=false,
     *         type="string",
     *         format="json",
     *     ),
     *     @SWG\Response(
     *         response="204",
     *         description="Returned when is added InterestUser successfully"
     *     ),
     *     @SWG\Response(
     *         response="403",
     *         description="Returned when the user is not authorized"
     *     ),
     *     @SWG\Response(
     *         response="404",
     *         description="Returned when the Interest is not found"
     *     )
     * )
     *
     */
    public function addInterestUserAction(Interest $interest, Request $request) {
        die("Hola");
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $user = $this->getUser();

    }

    public function removeInterestUserAction(Request $request) {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $user = $this->getUser();

    }
}