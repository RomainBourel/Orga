<?php

namespace App\EventSubscriber;

use App\Entity\Location;
use App\Repository\LocationRepository;
use Doctrine\Bundle\DoctrineBundle\EventSubscriber\EventSubscriberInterface;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Events;


class LocationSubscriber implements EventSubscriberInterface
{

    public function __construct(private LocationRepository $locationRepository)
    {
    }

    public function getSubscribedEvents(): array
    {
        return [
            Events::prePersist,
            Events::preUpdate,
        ];
    }

    public function prePersist(LifecycleEventArgs $args): void
    {
        $this->logActivity('persist', $args);
    }

    public function preUpdate(LifecycleEventArgs $args): void
    {
        $this->logActivity('update', $args);
    }

    private function logActivity(string $action, LifecycleEventArgs $args): void
    {
        $entity = $args->getObject();

        if (!$entity instanceof Location) {
            return;
        }

        if (in_array($action, ['persist', 'update']) && $entity->isPrincipal()) {
            $this->locationRepository->findOneByPrincipal(true)->setPrincipal(false);
        }
    }
}
