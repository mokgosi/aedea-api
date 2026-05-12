<?php

// src/Controller/SecurityController.php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
// use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use App\Service\AuthService;

class SecurityController extends AbstractController
{
    #[Route('/login', name: 'app_login', methods: ['GET', 'POST'])]
    public function login(Request $request, AuthService $authService, SessionInterface $session): Response 
    {

        if ($request->isMethod('POST')) {

            $email = $request->request->get('_username');
            $password = $request->request->get('_password');

            $result = $authService->authenticate(
                $email,
                $password
            );

            if (!$result) {

                $this->addFlash('error', 'Invalid email or password.');

                return $this->redirectToRoute('app_login');
            }

            $session->set('jwt_token', $result['token']); 

            $session->set('admin_user', [
                'id' => $result['user']->getId(),
                'email' => $result['user']->getEmail(),
            ]);

            return $this->redirectToRoute('app_contact_index');

        }

        return $this->render('security/login.html.twig');
    }

    #[Route('/logout', name: 'app_logout')]
    public function logout(SessionInterface $session): Response
    {
        // $session->remove('jwt_token');
        // $session->remove('admin_user');
        $session->invalidate();

        return $this->redirectToRoute('homepage');
    }
}