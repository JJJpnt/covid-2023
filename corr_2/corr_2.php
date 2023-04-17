<?php

// On lit le contenu du fichier JSON
$json = file_get_contents('../open_stats_coronavirus.json');

var_dump($json);    // Affiche le contenu du fichier JSON
// On voit que c'est une simple chaîne de caractères

// On décode le JSON en tableau associatif PHP
$data = json_decode($json, true);
// On peut aussi utiliser json_decode($json, false) pour obtenir un objet

// Parcourir les objets dans le tableau
foreach ($data as $obj) {
    // Et les traîter de la manière de notre choix
    // Par exemple ici, je veux les données de la France pour le 21 février 2020
    // En vérifiant si la date et le nom correspondent
    if ($obj['date'] == '2020-02-21' && $obj['nom'] == 'france') {
        // Accéder aux autres propriétés de l'objet
        $nombre_de_cas = $obj['cas'];
        $nombre_de_deces = $obj['deces'];
        $nombre_de_guerisons = $obj['guerisons'];
        $source = $obj['source'];

        // Faire quelque chose avec les données...
        // Par exemple, afficher le nombre de cas, et le nombre de guérisons :
        echo "Données en france le 21 février 2020 : Nombre de cas : $nombre_de_cas, Nombre de guérisons : $nombre_de_guerisons <br>";
        // Etc...
    }
}