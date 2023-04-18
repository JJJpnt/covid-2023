<?php

// Les ternaires en PHP sont une forme abrégée de la structure if...else.
// Ils permettent de réaliser une opération conditionnelle en une seule
// ligne de code.


// Quand utiliser une ternaire au lieu d'une structure if...else ?
// - On les utilise en général quand on a un choix simple à faire, et qu'on veut
// affecter une valeur à une variable en fonction de la valeur d'une autre variable.
// - Si on a un choix plus complexe, il vaut mieux utiliser une structure if...else.
// - Egalement si on veut exécurer une fonction en fonction d'une condition,
// il vaut mieux utiliser une structure if...else.

// Exemple :

$age = 18;
$message = ($age >= 18) ? "Vous êtes majeur." : "Vous êtes mineur.";
echo $message;

// Dans cet exemple, nous avons une variable $age qui contient l'âge d'une personne.
// Nous utilisons une structure ternaire pour déterminer si cette personne est majeure
// ou mineure, en fonction de la valeur de $age.

// La structure ternaire est composée de 3 parties :
// - La condition à tester
// - La valeur à affecter si la condition est vraie
// - La valeur à affecter si la condition est fausse

// La condition à tester ici est entre parenthèses, et se termine par un point 
// d'interrogation.

// La valeur à affecter si la condition est vraie est juste après le point d'interrogation,
// et se termine par un double point. Ici, c'est "Vous êtes majeur."
// La valeur à affecter si la condition est fausse est juste après le double point.
// Ici, c'est "Vous êtes mineur."

// Le résultat de l'expression ternaire est stocké dans la variable $message, qui est ensuite
// affichée à l'aide de la fonction echo.
