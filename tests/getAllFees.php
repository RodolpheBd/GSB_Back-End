<?php
require 'vendor/autoload.php';

use App\Service\FirebaseService;

try {
    // 🔥 Instanciation du service
    $firebaseService = new FirebaseService();
    echo "✅ FirebaseService instancié avec succès\n";

    // 🔎 Exécution du test
    $fees = $firebaseService->getAllFees();
    
    if (empty($fees)) {
        echo "⚠️ Aucun frais récupéré.\n";
    } else {
        echo "✅ Frais récupérés avec succès : \n";
        print_r($fees);
    }
} catch (\Exception $e) {
    echo "❌ Erreur lors du test : " . $e->getMessage() . "\n";
}