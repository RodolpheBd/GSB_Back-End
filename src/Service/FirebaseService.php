<?php

namespace App\Service;

use Kreait\Firebase\Factory;
use Kreait\Firebase\Database;
use Kreait\Firebase\Auth;
use Google\Cloud\Firestore\FirestoreClient;

class FirebaseService
{
    private Database $database;
    private Auth $auth;
    private FirestoreClient $firestore;

    public function __construct()
    {

        $factory = (new Factory)
            ->withServiceAccount('C:\Users\Rodolphe\Projects\GSB_Back-End\config\firebase_credentials.json');

        $this->database = $factory->createDatabase();
        $this->auth = $factory->createAuth();
        $this->firestore = new FirestoreClient([
            'keyFilePath' => 'C:\Users\Rodolphe\Projects\GSB_Back-End\config\firebase_credentials.json'
        ]);
    }

    public function getDatabase(): Database
    {
        return $this->database;
    }

    public function getAuth(): Auth
    {
        return $this->auth;
    }

    public function getData(string $path): array
    {
        return $this->database->getReference($path)->getValue();
    }

    public function getAllUsers(): array
    {
        try {
            $users = $this->auth->listUsers();
            $userList = [];

            foreach ($users as $user) {
                $userList[] = [
                    'id' => $user->uid,
                    'email' => $user->email,
                    'role' => $user->customClaims['role'] ?? 'Non défini',
                ];
            }

            return $userList;
        } catch (\Exception $e) {
            return [];
        }
    }

    public function createUser(string $email, string $password): void
    {
        $this->auth->createUser([
            'email' => $email,
            'password' => $password,
        ]);
    }

    public function getAllFees(): array
    {
        $feesList = [];
        try {
            error_log("🔹 Début de getAllFees()");

            try {
                $userTest = $this->firestore->collection('users')->document('rodolphe@gmail.com')->snapshot();
                if (!$userTest->exists()) {
                    error_log("❌ L'utilisateur 'rodolphe@gmail.com' n'existe pas !");
                } else {
                    error_log("✅ L'utilisateur 'rodolphe@gmail.com' est bien récupéré !");
                }
            } catch (\Throwable $e) {
                error_log("❌ ERREUR Firestore utilisateur : " . $e->getMessage());
            }
            
            
            
            try {
                error_log("🟢 Début du test Firestore");
                $users = $this->firestore->collection('users')->documents();
                error_log("🟡 Firestore a répondu !");
            } catch (\Throwable $e) {
                error_log("❌ ERREUR LORS DE LA RÉCUPÉRATION : " . $e->getMessage());
            }
            
            error_log("🔹 Utilisateurs récupérés");

            foreach ($users as $user) {
                $userEmail = $user->id();
                error_log("🔹 Traitement de l'utilisateur : " . $userEmail);

                $fees = $this->firestore->collection("users/{$userEmail}/Fees")->documents();
                error_log("🔹 Frais récupérés pour $userEmail");

                foreach ($fees as $fee) {
                    $data = $fee->data();
                    $data['id'] = $fee->id();
                    $data['user_email'] = $userEmail;
                    $feesList[] = $data;
                }
            }

            error_log("✅ Fin de getAllFees() avec " . count($feesList) . " frais.");
        } catch (\Exception $e) {
            error_log("❌ ERREUR dans getAllFees() : " . $e->getMessage());
            return [];
        }
        return $feesList;
    }


    public function updateFeeStatus(string $email, string $feeId, bool $status): void
    {
        try {
            $this->firestore
                ->collection("users/{$email}/Fees")
                ->document($feeId)
                ->set(['status' => $status ? 'Validé' : 'Refusé'], ['merge' => true]);
        } catch (\Exception $e) {
            // Log ou gestion de l'erreur
        }
    }
}
