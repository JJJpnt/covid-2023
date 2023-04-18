<?php

// Exemples d'utilisation de la fonction array_filter
// Ternaires, et usort()

$animaux = array(
    array('nom' => 'Milo', 'type' => 'chat'),
    array('nom' => 'Buddy', 'type' => 'chien'),
    array('nom' => 'Luna', 'type' => 'chat'),
    array('nom' => 'Charlie', 'type' => 'chien'),
    array('nom' => 'Simba', 'type' => 'chat'),
    array('nom' => 'Max', 'type' => 'chien'),
    array('nom' => 'Smokey', 'type' => 'chat'),
    array('nom' => 'Rocky', 'type' => 'chien'),
    array('nom' => 'Bella', 'type' => 'chat'),
    array('nom' => 'Cooper', 'type' => 'chien')
);

$chats = array_filter($animaux, function($element) {
    return $element['type'] === 'chat';
});

var_dump($chats);

echo "A" > "B" ? "A est plus grand que B" : "A n'est pas plus grand que B";
echo "<br>";
echo "C" > "B" ? "C est plus grand que B" : "C n'est pas plus grand que B";
echo "<br>";
echo "2022" > "2021" ? "2022 est plus grand que 2021" : "2022 n'est pas plus grand que 2021";
echo "<br>";
echo "2021-01" > "2021-02" ? "2021-01 est plus grand que 2021-02" : "2021-01 n'est pas plus grand que 2021-02";
echo "<br>";
echo "2021-02-01" > "2021-02-02" ? "2021-02-01 est plus grand que 2021-02-02" : "2021-02-01 n'est pas plus grand que 2021-02-02";
echo "<br>";
echo "chat" > "CHAT" ? "chat est plus grand que CHAT" : "chat n'est pas plus grand que CHAT";


// Syntaxe ternaire, c'est comme un if en ligne
// condition ? valeur_si_vrai : valeur_si_faux

$aliments = array(
    array('nom' => 'Pomme', 'type' => 'fruit'),
    array('nom' => 'Brocoli', 'type' => 'legume'),
    array('nom' => 'Banane', 'type' => 'fruit'),
    array('nom' => 'Carotte', 'type' => 'legume'),
    array('nom' => 'Orange', 'type' => 'fruit'),
    array('nom' => 'Chou-fleur', 'type' => 'legume'),
    array('nom' => 'Poire', 'type' => 'fruit'),
    array('nom' => 'Tomate', 'type' => 'legume'),
    array('nom' => 'Kiwi', 'type' => 'fruit'),
    array('nom' => 'Poivron', 'type' => 'legume')
);

usort($aliments, function($a, $b) {
    if($a['type'] === "legume" && $b['type'] == "fruit") {
        return true;
    } else {
        return false;
    }
    // return $a['type'] === "legume" && $b['type'] === "fruit" ? true : false;
});

var_dump($aliments);