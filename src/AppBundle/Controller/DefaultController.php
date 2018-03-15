<?php

namespace AppBundle\Controller;

use AppBundle\EventListener\CustomerDeliveriesQueryHandler;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;


class DefaultController extends Controller
{
    /**
     * @Route("/users/{user_id}/deliveries", name="homepage")
     */
    public function userDeliveries($user_id)
    {
        if ($user_id){
            $customerDeliveriesQueryHandler = new CustomerDeliveriesQueryHandler();
            $deliveries = $customerDeliveriesQueryHandler->onCustomerDeliveriesQuery($user_id);


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
