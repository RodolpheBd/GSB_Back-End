<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Kreait\Firebase\Factory;
use Kreait\Firebase\ServiceAccount;

class FeesController extends AbstractController
{
    private $firestore;

    public function __construct()
    {
        $serviceAccount = ServiceAccount::fromValue(json_decode(file_get_contents('../config/firebase_credentials.json'), true));
        $firebase = (new Factory)->withServiceAccount($serviceAccount);
        $this->firestore = $firebase->createFirestore()->database();
    }

    #[Route('/visiteur/deplacement', name: 'ajout_deplacement', methods: ['GET', 'POST'])]
    public function ajoutDeplacement(Request $request): Response
    {
        if ($request->isMethod('POST')) {
            $data = [
                'categorie' => 'Deplacement',
                'montant' => $request->request->get('montant'),
                'date' => $request->request->get('date'),
                'justificatif' => $request->request->get('justificatif')
            ];


            $this->firestore->collection('users/test@gmail.com/Fees')->add($data);
            return $this->redirectToRoute('home');
        }
        return $this->render('dashboard/visiteur/deplacement.html.twig');
    }

    #[Route('/visiteur/restauration', name: 'ajout_restauration', methods: ['GET', 'POST'])]
    public function ajoutRestauration(Request $request): Response
    {
        if ($request->isMethod('POST')) {
            $data = [
                'categorie' => 'Restauration',
                'montant' => $request->request->get('montant'),
                'date' => $request->request->get('date'),
                'justificatif' => $request->request->get('justificatif')
            ];
            $this->firestore->collection('users/test@gmail.com/Fees')->add($data);
            return $this->redirectToRoute('home');
        }
        return $this->render('dashboard/visiteur/restauration.html.twig');
    }

    #[Route('/visiteur/hebergement', name: 'ajout_hebergement', methods: ['GET', 'POST'])]
    public function ajoutHebergement(Request $request): Response
    {
        if ($request->isMethod('POST')) {
            $data = [
                'categorie' => 'Hebergement',
                'montant' => $request->request->get('montant'),
                'date' => $request->request->get('date'),
                'justificatif' => $request->request->get('justificatif')
            ];
            $this->firestore->collection('users/test@gmail.com/Fees')->add($data);
            return $this->redirectToRoute('home');
        }
        return $this->render('dashboard/visiteur/hebergement.html.twig');
    }

    #[Route('/visiteur/cafe', name: 'ajout_cafe', methods: ['GET', 'POST'])]
    public function ajoutCafe(Request $request): Response
    {
        if ($request->isMethod('POST')) {
            $data = [
                'categorie' => 'Café',
                'montant' => $request->request->get('montant'),
                'date' => $request->request->get('date'),
                'justificatif' => $request->request->get('justificatif')
            ];
            $this->firestore->collection('users/test@gmail.com/Fees')->add($data);
            return $this->redirectToRoute('home');
        }
        return $this->render('dashboard/visiteur/cafe.html.twig');
    }
}
