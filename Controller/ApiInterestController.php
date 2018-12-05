<?php
namespace Opositatest\InterestUserBundle\Controller;

use Opositatest\InterestUserBundle\Entity\Interest;
use Opositatest\InterestUserBundle\Model\UserTrait;
use Opositatest\InterestUserBundle\Service\InterestService;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Swagger\Annotations as SWG;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Nelmio\ApiDocBundle\Annotation\Operation;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\SerializerInterface;

class ApiInterestController extends Controller {

    /**
     * Add interest to User
     *
     * @Route("/interest/{interest}", name="Add interest to User", methods={"POST"}))
     * @Operation(
     *     tags={"Interest"},
     *     summary="Add interest to User",
     *     produces={"application/json"},
     *     @SWG\Parameter(
     *         name="followMode",
     *         in="query",
     *         description="followInterest or unfollowInterest",
     *         enum={"followInterest", "unfollowInterest"},
     *         default="followInterest",
     *         required=false,
     *         type="string"
     *     ),
     *     @SWG\Parameter(
     *         name="blockBase",
     *         in="query",
     *         description="indicates if you can process the request even if there is a denied interest",
     *         type="integer",
     *         default="0",
     *         enum={0,1}
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
    public function postAction(Interest $interest, Request $request) {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $user = $this->getUser();

        /** @var InterestService $interestService */
        $interestService = $this->get('interestUser.interest');
        $success = $interestService->postInterestUserRecursiveChildren(
            $interest,
            $user,
            $request->get('followMode'),
            true,
            $request->get('blockBase'),
            $request->get('recursive')
        );
        return new JsonResponse($success);
    }


    /**
     * Remove interest from User
     *
     * @Route("/interest/{interest}", name="Remove interest from User", methods={"DELETE"}))
     * @Operation(
     *     tags={"Interest"},
     *     summary="Remove interest from User",
     *     produces={"application/json"},
     *     @SWG\Parameter(
     *         name="followMode",
     *         in="query",
     *         description="followInterest or unfollowInterest  ",
     *         enum={"followInterest", "unfollowInterest"},
     *         default="followInterest",
     *         required=false,
     *         type="string"
     *     ),
     *     @SWG\Response(
     *         response="204",
     *         description="Returned when is removed InterestUser successfully"
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
    public function deleteAction(Interest $interest, Request $request) {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $user = $this->getUser();

        /** @var InterestService $interestService */
        $interestService = $this->get('interestUser.interest');
        $success = $interestService->deleteInterestUserRecursiveChildren(
            $interest,
            $user,
            $request->get('followMode'),
            true);

        return new JsonResponse($success);
    }

    /**
     * Get general interests and interests from User
     *
     * @Route("/interests", name="Get general interests and interests from User", methods={"GET"}))
     * @Operation(
     *     tags={"Interest"},
     *     summary="Get general interests and interests from User",
     *     consumes={"multipart/form-data"},
     *     produces={"application/json"},
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
    public function getAction(Request $request) {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        /** @var UserTrait $user */
        $user = $this->getUser();

        /** @var InterestService $interestService */
        $interestService = $this->get('interestUser.interest');
        $interests = $interestService->getInterests();
        $data = array(
            'user' => $user,
            'interests' => $interests
        );


        /** @var SerializerInterface $serializer */
        $serializer = $this->get('serializer');
        $dataJson = $serializer->serialize(
            $data,
            'json', array('groups' => array('interestUserView'))
        );

        return new Response($dataJson);
    }
}