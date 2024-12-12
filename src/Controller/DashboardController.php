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

    // Tableau de bord pour les Admins
    #[Route('/admin', name: 'admin_dashboard')]
    public function adminDashboard(): Response
    {
        return $this->render('dashboard/admin.html.twig', [
            'page_title' => 'Tableau de bord Admin',
        ]);
    }

    // Tableau de bord pour les Comptables
    #[Route('/comptabilite', name: 'comptabilite_dashboard')]
    public function comptabiliteDashboard(): Response
    {
        return $this->render('dashboard/comptabilite.html.twig', [
            'page_title' => 'Tableau de bord Comptabilité',
        ]);
    }

    // Tableau de bord pour les Visiteurs
    #[Route('/visiteur', name: 'visiteur_dashboard')]
    public function visiteurDashboard(): Response
    {
        return $this->render('dashboard/visiteur.html.twig', [
            'page_title' => 'Tableau de bord Visiteur',
        ]);
    }
}
