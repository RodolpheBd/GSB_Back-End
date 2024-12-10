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
        // Rediriger l'utilisateur en fonction de son rôle
        if ($this->isGranted('ROLE_ADMIN')) {
            return $this->redirectToRoute('admin_dashboard');
        } elseif ($this->isGranted('ROLE_COMPTA')) {
            return $this->redirectToRoute('compta_dashboard');
        } else {
            return $this->redirectToRoute('visiteur_dashboard');
        }
    }
}
