<?php
require 'vendor/autoload.php';

use Google\Cloud\Firestore\FirestoreClient;

try {
    $firestore = new FirestoreClient([
        'keyFilePath' => 'C:\Users\Rodolphe\GSB_Symfony\config\firebase_credentials.json'
    ]);

    echo "Connexion Firestore réussie !";
} catch (\Exception $e) {
    echo "Erreur Firestore : " . $e->getMessage();
}
