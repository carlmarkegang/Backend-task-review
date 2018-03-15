<?php

namespace AppBundle\Controller;

use AppBundle\EventListener\CustomerDeliveriesQueryHandler;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use AppBundle\Entity\User;
use \Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class DefaultController extends Controller
{
    /**
     * @Route("/users/{user_id}/deliveries", name="homepage")
     */
    public function userDeliveries($user_id)
    {
        if ($user_id){
            $user = $this->getDoctrine()->getRepository(User::class)->find($user_id);

            if(!$user)
                throw new NotFoundHttpException('user not found');

            $customerDeliveriesQueryHandler = new CustomerDeliveriesQueryHandler();
            $deliveries = $customerDeliveriesQueryHandler->onCustomerDeliveriesQuery($user);


            $userDeliveries = [];
            foreach ($deliveries->getUserDeliveries() as $delivery) {
                array_push($userDeliveries, $delivery->getDescription());
            }

        }

        return $this->json(array(
            'userId' => $deliveries->getUserId(),
            'deliveries' => $userDeliveries
            ));

    }
}
