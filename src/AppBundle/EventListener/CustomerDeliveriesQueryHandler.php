<?php
namespace AppBundle\EventListener;

use AppBundle\Event\CustomerDeliveriesQuery;
use Symfony\Component\EventDispatcher\Event;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\HttpFoundation\JsonResponse;

class CustomerDeliveriesQueryHandler
{

    public function onCustomerDeliveriesQuery($user)
    {
        $dispatcher = new EventDispatcher();
        $customerDeliveriesQuery = new CustomerDeliveriesQuery($user);
        $dispatcher->dispatch(CustomerDeliveriesQuery::NAME, $customerDeliveriesQuery);
        return $customerDeliveriesQuery;
    }
}