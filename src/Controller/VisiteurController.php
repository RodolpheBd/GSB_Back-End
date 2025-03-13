<?php

namespace App\Controller;

use App\Service\FirebaseService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class VisiteurController extends AbstractController
{
    private FirebaseService $firebaseService;

    public function __construct(FirebaseService $firebaseService)
    {
        $this->firebaseService = $firebaseService;
    }

    #[Route('/visiteur', name: 'visiteur_dashboard')]
    public function index(): Response
    {
        // Pour l'instant, on ne récupère pas les frais ici, juste pour l'affichage de la page d'accueil.
        return $this->render('dashboard/visiteur.html.twig', [
            'page_title' => 'Tableau de bord Visiteur',
        ]);
    }

    #[Route('/visiteur/cafes', name: 'visiteur_cafes')]
    public function cafes(): Response
    {
        // Récupérer les frais pour la catégorie "cafes"
        // $fees = $this->firebaseService->getFeesByCategory('cafes');

        return $this->render('dashboard/visiteur/cafe.html.twig', [
            'page_title' => 'Frais café',
            // 'fees' => $fees,
        ]);
    }

    #[Route('/visiteur/hebergements', name: 'visiteur_hebergements')]
    public function hebergements(): Response
    {
        // Récupérer les frais pour la catégorie "hebergements"
        // $fees = $this->firebaseService->getFeesByCategory('hebergements');

        return $this->render('dashboard/visiteur/hebergement.html.twig', [
            'page_title' => 'Frais hébergement',
            // 'fees' => $fees,
        ]);
    }

    #[Route('/visiteur/deplacements', name: 'visiteur_deplacements')]
    public function deplacements(): Response
    {
        // Récupérer les frais pour la catégorie "deplacements"
        // $fees = $this->firebaseService->getFeesByCategory('deplacements');

        return $this->render('dashboard/visiteur/deplacement.html.twig', [
            'page_title' => 'Frais déplacement',
            // 'fees' => $fees,
        ]);
    }

    #[Route('/visiteur/restaurations', name: 'visiteur_restaurations')]
    public function restaurations(): Response
    {
        // Récupérer les frais pour la catégorie "restaurations"
        // $fees = $this->firebaseService->getFeesByCategory('restaurations');

        return $this->render('dashboard/visiteur/restauration.html.twig', [
            'page_title' => 'Frais restauration',
            // 'fees' => $fees,
        ]);
    }

    // Décommenter si tu souhaites ajouter une méthode pour ajouter un frais
    // public function addFee(Request $request): Response
    // {
    //     // Récupérer les données envoyées par la requête POST
    //     $category = $request->request->get('category');
    //     $amount = $request->request->get('amount');

    //     // Ajouter le frais via le service Firebase
    //     $this->firebaseService->addFee($category, $amount);

    //     // Rediriger vers la page visiteur
    //     return $this->redirectToRoute('visiteur_index');
    // }
}
