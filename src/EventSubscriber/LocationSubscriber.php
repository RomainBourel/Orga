<?php

namespace App\EventSubscriber;

use App\Entity\Location;
use App\Repository\LocationRepository;
use Doctrine\Bundle\DoctrineBundle\EventSubscriber\EventSubscriberInterface;
use Doctrine\ORM\Event\OnFlushEventArgs;
use Doctrine\ORM\Events;


class LocationSubscriber implements EventSubscriberInterface
{

    public function __construct(
        private LocationRepository $locationRepository,
    ){}

    public function getSubscribedEvents(): array
    {
        return [
            Events::onFlush,
        ];
    }

    public function onFlush(OnFlushEventArgs $args): void
    {
        $em = $args->getObjectManager();
        $uow = $em->getUnitOfWork();

        foreach ($uow->getScheduledEntityUpdates() as $entity) {
            if ($entity instanceof Location) {
                if ($entity->isPrincipal()) {
                    $ActualPrincipalEntity = $this->locationRepository->findOneByPrincipal(true)->setPrincipal(false);
                    $uow->computeChangeSet($em->getClassMetadata(Location::class), $ActualPrincipalEntity);
                }
            }
        }
        foreach ($uow->getScheduledEntityInsertions() as $entity) {
            if ($entity instanceof Location) {
                if ($entity->isPrincipal()) {
                    $ActualPrincipalEntity = $this->locationRepository->findOneByPrincipal(true)->setPrincipal(false);
                    $uow->computeChangeSet($em->getClassMetadata(Location::class), $ActualPrincipalEntity);
                }
            }
        }
    }

}
