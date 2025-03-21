<?php

namespace App\Controller;

use App\Service\FirebaseService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class VisiteurController extends AbstractController
{
    private FirebaseService $firebaseService;

    public function __construct(FirebaseService $firebaseService)
    {
        $this->firebaseService = $firebaseService;
    }

    #[Route('/visiteur', name: 'visiteur_dashboard')]
    public function index(Request $request): Response
    {
        // $session = $request->getSession(); // 🔥 Récupération correcte de la session
        // $userEmail = $session->get('user_email');
        // $feesList = [];
        
        // if ($userEmail) {
        //     $feesList = $this->firebaseService->getUserFees($userEmail);
        // }
        
        return $this->render('dashboard/visiteur.html.twig', [
            'page_title' => 'Tableau de bord Visiteur',
            // 'fees_list' => $feesList
        ]);
    }

    #[Route('/visiteur/cafes', name: 'visiteur_cafes')]
    public function cafes(Request $request): Response
    {
        return $this->render('dashboard/visiteur/cafe.html.twig', [
            'page_title' => 'Frais café',
        ]);
    }

    #[Route('/visiteur/hebergements', name: 'visiteur_hebergements')]
    public function hebergements(Request $request): Response
    {
        return $this->render('dashboard/visiteur/hebergement.html.twig', [
            'page_title' => 'Frais hébergement',
        ]);
    }

    #[Route('/visiteur/deplacements', name: 'visiteur_deplacements')]
    public function deplacements(Request $request): Response
    {
        return $this->render('dashboard/visiteur/deplacement.html.twig', [
            'page_title' => 'Frais déplacement',
        ]);
    }

    #[Route('/visiteur/restaurations', name: 'visiteur_restaurations')]
    public function restaurations(): Response
    {
        return $this->render('dashboard/visiteur/restauration.html.twig', [
            'page_title' => 'Frais restauration',
        ]);
    }
}
