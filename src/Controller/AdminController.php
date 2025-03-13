<?php
namespace App\Controller;

use App\Service\FirebaseService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
{
    private FirebaseService $firebaseService;

    public function __construct(FirebaseService $firebaseService)
    {
        $this->firebaseService = $firebaseService;
    }

    #[Route('/admin', name: 'admin_dashboard')]
    public function index(): Response
    {
        $users = $this->firebaseService->getAllUsers(); // Récupère les utilisateurs de Firebase

        return $this->render('dashboard/admin.html.twig', [
            'profils' => $users,
        ]);
    }

    #[Route('/admin/create', name: 'create_user', methods: ['POST'])]
    public function createUser(Request $request): Response
    {
        $email = $request->request->get('email');
        $password = $request->request->get('password');

        try {
            $this->firebaseService->createUser($email, $password);
            $this->addFlash('success', "Utilisateur créé avec succès !");
        } catch (\Exception $e) {
            $this->addFlash('error', "Erreur lors de la création : " . $e->getMessage());
        }

        return $this->redirectToRoute('admin_dashboard');
    }
}
