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
            ->withServiceAccount('GSB_Symfony\config\firebase_credentials.json');

        $this->database = $factory->createDatabase();
        $this->auth = $factory->createAuth();
        $this->firestore = new FirestoreClient([
            'keyFilePath' => 'GSB_Symfony\config\firebase_credentials.json' // 🔥 Assure-toi que le chemin est correct
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
            $users = $this->firestore->collection('users')->documents();
            foreach ($users as $user) {
                $userEmail = $user->id(); 
                $fees = $this->firestore->collection("users/{$userEmail}/Fees")->documents();

                foreach ($fees as $fee) {
                    $data = $fee->data();
                    $data['id'] = $fee->id();
                    $data['user_email'] = $userEmail;
                    $feesList[] = $data;
                }
            }
        } catch (\Exception $e) {
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