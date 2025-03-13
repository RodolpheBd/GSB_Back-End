<?php

namespace App\Controller;

use App\Service\FirebaseService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ComptabiliteController extends AbstractController
{
    private FirebaseService $firebaseService;

    public function __construct(FirebaseService $firebaseService)
    {
        $this->firebaseService = $firebaseService;
    }

    #[Route('/comptabilite', name: 'comptabilite_dashboard')]
    public function index(): Response
    {
        $feesList = $this->firebaseService->getAllFees();
        return $this->render('dashboard/comptabilite.html.twig', [
            'fees_list' => $feesList,
            'page_title' => 'Tableau de bord Comptable',

        ]);
    }

    #[Route('/comptabilite/validate', name: 'validate_fee', methods: ['POST'])]
    public function validateFee(Request $request): Response
    {
        $email = $request->request->get('user_email');
        $feeId = $request->request->get('fee_id');

        if ($email && $feeId) {
            $this->firebaseService->updateFeeStatus($email, $feeId, true);
            $this->addFlash('success', 'Frais validé avec succès !');
        } else {
            $this->addFlash('error', 'Erreur lors de la validation.');
        }

        return $this->redirectToRoute('comptabilite_dashboard');
    }

    #[Route('/comptabilite/reject', name: 'reject_fee', methods: ['POST'])]
    public function rejectFee(Request $request): Response
    {
        $email = $request->request->get('user_email');
        $feeId = $request->request->get('fee_id');

        if ($email && $feeId) {
            $this->firebaseService->updateFeeStatus($email, $feeId, false);
            $this->addFlash('error', 'Frais refusé.');
        } else {
            $this->addFlash('error', 'Erreur lors du refus.');
        }

        return $this->redirectToRoute('comptabilite_dashboard');
    }
}
