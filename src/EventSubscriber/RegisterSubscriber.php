<?php

namespace App\EventSubscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Security\Core\Event\AuthenticationSuccessEvent;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Contracts\Translation\TranslatorInterface;

class RegisterSubscriber implements EventSubscriberInterface
{
    public function __construct(private TranslatorInterface $translator)
    {
    }
    public static function getSubscribedEvents()
    {
        return [
            AuthenticationSuccessEvent::class => 'onAuthenticationSuccess'
        ];
    }
    public function onAuthenticationSuccess(AuthenticationSuccessEvent $event)
    {
        $user = $event->getAuthenticationToken()->getUser();
        if (!$user->isVerified()) {
            throw new AuthenticationException($this->translator->trans('error.verified', ['%email%' => $user->getEmail()]));
        }
    }
}
