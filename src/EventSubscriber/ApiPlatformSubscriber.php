<?php

// src/EventSubscriber/ApiPlatformSubscriber.php

namespace App\EventSubscriber;

use ApiPlatform\Core\EventListener\EventPriorities;
use App\Entity\Gpx;
use EasyCorp\Bundle\EasyAdminBundle\Event\BeforeEntityDeletedEvent;
use EasyCorp\Bundle\EasyAdminBundle\Event\BeforeEntityPersistedEvent;
use EasyCorp\Bundle\EasyAdminBundle\Event\BeforeEntityUpdatedEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Event\ViewEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

class ApiPlatformSubscriber implements EventSubscriberInterface
{
    private $authorizationChecker;

    public function __construct(AuthorizationCheckerInterface $authorizationChecker)
    {
        $this->authorizationChecker = $authorizationChecker;
    }

    public static function getSubscribedEvents()
    {
        return [
            BeforeEntityPersistedEvent::class => ['CheckPersistPermission'],
            BeforeEntityUpdatedEvent::class => ['CheckEditPermission'],
            BeforeEntityDeletedEvent::class => ['CheckRemovePermission'],
        ];
    }
    public function CheckPersistPermission(BeforeEntityPersistedEvent $event)
    {
        $entity = $event->getEntityInstance();

        $this->authorizationChecker->isGranted(null, $entity) || $this->denyAccess();
    }

    public function CheckEditPermission(BeforeEntityUpdatedEvent $event)
    {
        $entity = $event->getEntityInstance();

        $this->authorizationChecker->isGranted(null, $entity) || $this->denyAccess();
    }

    public function CheckRemovePermission(BeforeEntityDeletedEvent $event)
    {
        $entity = $event->getEntityInstance();

        $this->authorizationChecker->isGranted(null, $entity) || $this->denyAccess();
    }

    private function denyAccess()
    {
        throw new AccessDeniedHttpException('Access Denied');
    }
}
