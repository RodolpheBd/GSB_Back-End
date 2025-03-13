<?php
require 'vendor/autoload.php';

use App\Service\FirebaseService;

try {
    // 🔥 Instanciation du service
    $firebaseService = new FirebaseService();
    echo "✅ FirebaseService instancié avec succès\n";

    // 🔎 Test : Récupération de tous les frais
    echo "🔍 Récupération des frais...\n";

    try {
        $feesList = $firebaseService->getAllFees();
        echo "🟢 getAllFees() a bien été exécutée.\n"; // <-- Vérification si la fonction se termine
    } catch (\Throwable $e) {
        echo "❌ ERREUR CRITIQUE dans getAllFees() : " . $e->getMessage() . "\n";
        echo "📝 Stack trace : \n" . $e->getTraceAsString() . "\n";
        exit;
    }

    // Vérification : est-ce que la fonction a retourné quelque chose ?
    if (!isset($feesList)) {
        echo "❌ ERREUR : La fonction getAllFees() ne retourne rien.\n";
        exit;
    }

    // Vérification 1 : est-ce bien un tableau ?
    if (!is_array($feesList)) {
        echo "❌ Erreur : getAllFees() ne retourne pas un tableau.\n";
        var_dump($feesList);
        exit;
    }

    // Vérification 2 : Y a-t-il des frais récupérés ?
    if (empty($feesList)) {
        echo "⚠️ Aucun frais récupéré.\n";
    } else {
        echo "✅ Frais récupérés avec succès :\n";
        print_r($feesList);
    }

} catch (\Exception $e) {
    echo "❌ ERREUR GÉNÉRALE : " . $e->getMessage() . "\n";
}
