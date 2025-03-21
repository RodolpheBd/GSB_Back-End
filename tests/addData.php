<?php

require 'vendor/autoload.php'; // Assurez-vous que l'autoload est chargé correctement

use Kreait\Firebase\Factory;
use Kreait\Firebase\ServiceAccount;

echo "Début du script PHP\n";

// Chargement de la configuration Firebase
$serviceAccount = ServiceAccount::fromValue(json_decode(file_get_contents('C:\Users\Rodolphe\Projects\GSB_Back-End\config\firebase_credentials.json'), true));

// Initialisation de Firebase avec les identifiants du compte de service
$firebase = (new Factory)->withServiceAccount($serviceAccount);

// Création d'un objet Firestore
$firestore = $firebase->createFirestore();

// Test d'ajout de données dans Firebase Firestore
try {
    $data = [
        'categorie' => 'Test',
        'montant' => 100,
        'date' => '2025-03-21',
        'justificatif' => 'Test justificatif'
    ];

    // Ajout des données dans Firestore (dans une collection spécifique)
$firestore->database()->collection('users/rodolphe@gmail.com/Fees')->add($data);
    echo "Données ajoutées avec succès !";
} catch (Exception $e) {
    echo 'Erreur lors de l\'ajout des données : ',  $e->getMessage(), "\n";
}

?>