<?php

namespace App\Controller;

use App\Service\FirebaseService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class LoginController extends AbstractController
{
    private FirebaseService $firebaseService;

    public function __construct(FirebaseService $firebaseService)
    {
        $this->firebaseService = $firebaseService;
    }

    #[Route('/login', name: 'login', methods: ['POST'])]
    public function login(Request $request, SessionInterface $session): Response
    {
        $email = $request->request->get('_username');
        $password = $request->request->get('_password');
        $role = $request->request->get('role'); // Le rôle choisi par l'utilisateur

        try {
            // 🔹 Authentification avec Firebase
            $auth = $this->firebaseService->getAuth();
            $signInResult = $auth->signInWithEmailAndPassword($email, $password);

            // 🔹 Récupérer l'ID utilisateur Firebase
            $idTokenString = $signInResult->idToken();
            $verifiedIdToken = $auth->verifyIdToken($idTokenString);
            $userId = $verifiedIdToken->claims()->get('sub');

            // 🔹 Stocker les infos en session (y compris le rôle choisi)
            $session->set('user_id', $userId);
            $session->set('user_email', $email);
            $session->set('user_role', $role);

            $this->addFlash('success', 'Connexion réussie.');

            // 🔹 Redirection en fonction du rôle CHOISI
            return match ($role) {
                'admin' => $this->redirectToRoute('admin_dashboard'),
                'comptabilite' => $this->redirectToRoute('comptabilite_dashboard'),
                'visiteur' => $this->redirectToRoute('visiteur_dashboard'),
                default => $this->redirectToRoute('visiteur_dashboard'),
            };

        } catch (\Exception $e) {
            $this->addFlash('error', 'Échec de connexion : ' . $e->getMessage());
            return $this->redirectToRoute('login_page');
        }
    }


    #[Route('/login', name: 'login_page', methods: ['GET'])]
    public function loginPage(): Response
    {
        return $this->render('security/login.html.twig');
    }

    #[Route('/logout', name: 'logout')]
    public function logout(SessionInterface $session): Response
    {
        $session->clear();
        $this->addFlash('success', 'Déconnexion réussie.');
        return $this->redirectToRoute('login_page');
    }
}
