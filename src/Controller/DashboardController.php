<?php
namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class DashboardController extends AbstractController
{
    #[Route('/dashboard', name: 'dashboard')]
    public function dashboard(): Response
    {
        $roleRoutes = [
            'ROLE_ADMIN' => 'admin_dashboard',
            'ROLE_COMPTA' => 'comptabilite_dashboard',
            'ROLE_VISITEUR' => 'visiteur_dashboard',
        ];

        // Vérification des rôles et redirection
        foreach ($roleRoutes as $role => $route) {
            if ($this->isGranted($role)) {
                return $this->redirectToRoute($route);
            }
        }

        // Si aucun rôle ne correspond, rediriger vers une page par défaut ou générer une erreur
        throw $this->createAccessDeniedException('Vous n\'avez pas accès à cette section.');
    }
}
