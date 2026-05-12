<?php

// src/EventSubscriber/JwtAuthSubscriber.php

namespace App\EventSubscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\HttpFoundation\RequestStack;

class JwtAuthSubscriber implements EventSubscriberInterface
{
    public function __construct(
        private readonly RequestStack $requestStack,
        private readonly RouterInterface $router
    ) {
    }

    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::REQUEST => 'onKernelRequest',
        ];
    }

    public function onKernelRequest(RequestEvent $event): void
    {
        $request = $event->getRequest();

        $protectedRoutes = [
            'app_contact_index', 
            'app_contact_show',
            'app_contact_delete',
        ];

        $route = $request->attributes->get('_route');

        if (!in_array($route, $protectedRoutes, true)) {
            return;
        }

        $session = $this->requestStack
            ->getSession();

        if (!$session) {
            return;
        }

        $token = $session->get('jwt_token');

        if (!$token) {

            $event->setResponse(
                new RedirectResponse(
                    $this->router->generate('app_login')
                )
            );
        }
    }
}