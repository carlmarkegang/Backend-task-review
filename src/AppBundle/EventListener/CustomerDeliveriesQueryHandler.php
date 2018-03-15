<?php
namespace AppBundle\EventListener;

use AppBundle\Event\CustomerDeliveriesQuery;
use Symfony\Component\EventDispatcher\Event;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\HttpFoundation\JsonResponse;
use \Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use AppBundle\Entity\User;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\EntityManagerInterface;

class CustomerDeliveriesQueryHandler
{
    private $repository;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->repository = $entityManager->getRepository(User::class);
    }

    public function onCustomerDeliveriesQuery($user_id)
    {
        $user = $this->repository->find($user_id);

        if(!$user)
            throw new NotFoundHttpException('user not found');

        $dispatcher = new EventDispatcher();
        $customerDeliveriesQuery = new CustomerDeliveriesQuery($user);
        $dispatcher->dispatch(CustomerDeliveriesQuery::NAME, $customerDeliveriesQuery);
        return $customerDeliveriesQuery;
    }
}