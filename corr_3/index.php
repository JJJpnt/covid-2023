<?php

// On lit le contenu du fichier JSON, on le décode, et on traîte ses données
$json = file_get_contents('../open_stats_coronavirus.json');
$data = json_decode($json, true);

// Je veux filtrer les données

$dateDebut = '2021-01-01'; // Date de début de la période de filtrage
$dateFin = '2021-01-04'; // Date de fin de la période de filtrage
$pays = 'france'; // Pays pour lequel je veux filtrer les données

$timestampDebut = strtotime($dateDebut); // Convertir la date de début en timestamp
$timestampFin = strtotime($dateFin); // Convertir la date de fin en timestamp

// Utiliser array_filter pour filtrer les éléments du tableau
$filteredData = array_filter($data, function($item) use ($timestampDebut, $timestampFin, $pays) {
    $timestampElement = strtotime($item['date']); // Convertir la date de l'élément en timestamp
    return $item['nom'] === $pays && $timestampElement >= $timestampDebut && $timestampElement <= $timestampFin;
    // Retourner true si le nom de l'élément est "france" et que la date de l'élément est comprise entre la date de début et la date de fin
});

// Je trie le tableau par date en utilisant la fonction usort() qui prend en paramètre un tableau et une fonction
// de comparaison (ici, strcmp() qui compare deux chaînes de caractères), pour être sûr que les données soient triées
usort($filteredData, function($a, $b) {
    return strcmp($a['date'], $b['date']);
});

// Pour l'instant nous avons un tableau contenant les données pour la france entre deux dates, du type :
// 0 => 
// array (size=7)
//   'date' => string '2021-01-01' (length=10)
//   'code' => string 'P1' (length=2)
//   'nom' => string 'france' (length=6)
//   'cas' => string '2639773' (length=7)
//   'deces' => string '64765' (length=5)
//   'guerisons' => string '194901' (length=6)
//   'source' => string 'Santé Publique France' (length=22)
// ...

// Je veux regrouper, les dates et par exemple les décès dans des tabeaux simples, pour pouvoir les afficher dans un graphique :

$dates = []; // Tableau contenant les dates
$deces = []; // Tableau contenant les décès

// Pour chaque élément du tableau, je récupère la date et le nombre de décès
foreach ($filteredData as $item) {
    $dates[] = $item['date'];
    $deces[] = intval($item['deces']);  // Je convertis en integer pour pouvoir faire des calculs avec (et par souci de cohérence)
}

// Je peux maintenant afficher ces données dans un graphique, par exemple avec Chart.js
// Chart.js est une librairie JavaScript qui permet de créer des graphiques de manière simple et efficace
// Elle attend des données sous la forme d'un tableau de chaînes de caractères pour les abscisses, et un tableau de nombres pour les ordonnées
// Comment transformer un tableau PHP en une chaîne de caractère que je peux passer à mon JS ?
// Je peux tout simplement utiliser json_encode() pour transformer un tableau PHP en une chaîne de caractères JSON

var_dump($dates);
var_dump($deces);
echo json_encode($dates) . "<br>";
echo json_encode($deces) . "<br>";

$graphAbcsisses = json_encode($dates);
$graphOrdonnees = json_encode($deces);

// ------------------------------------------------------------------------------------------------------

// Pour aller plus loin : On peut optimiser le code pour qu'il soit efficace, en utilisant par exemple array_map() et/ou mieux, array_column()
// Essayez par exemple :
// Je récupère un tableau associatif sous la forme ['date' => '2021-01-01', 'deces' => '64765']
$decesByDate = array_column($filteredData, 'deces', 'date');
// Je convertis toutes les valeurs de décès en integer, par souci de cohérence (optionnel, dans ce cas, mais souvent nécessaire pour éviter des bugs)
$decesByDate = array_map(function($item) {
    return (int) $item;
}, $decesByDate);

var_dump($decesByDate);
echo json_encode(array_keys($decesByDate)) . "<br>";
echo json_encode(array_values($decesByDate)) . "<br>";

$graphAbcsisses = json_encode(array_keys($decesByDate));
$graphOrdonnees = json_encode(array_values($decesByDate));

// Cela donne le même résultat qu'avec le foreach ci-dessus, mais en quelques lignes de code, et en plus efficace

// ------------------------------------------------------------------------------------------------------


?>

<!DOCTYPE html>
<html>
<head>
	<title>Covid Trrrrrrrkrrrrrrr</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!-- Inclure Bootstrap -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
	<style>
		.navbar-brand img {
			max-height: 50px;
		}
		.nav-link {
			font-weight: bold;
			color: #333;
		}
		.nav-link:hover {
			color: #ff8b94;
		}
		.footer {
			background-color: #333;
			color: white;
			padding: 20px;
		}
		.chart-container {
            min-height: 80vh;
		}
	</style>
	<!-- Inclure Chart.js -->
	<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
	<nav class="navbar navbar-expand-lg navbar-light bg-light">
		<div class="container">
			<a class="navbar-brand" href="#">
				<!-- <img src="https://via.placeholder.com/150x50" alt="Logo"> -->

                <svg width="150px" height="50px" viewBox="0 0 150 50" xmlns="http://www.w3.org/2000/svg">
                  <circle cx="25" cy="25" r="20" fill="#f0f0f0" />
                  <circle cx="75" cy="25" r="20" fill="#e7e7e7" />
                  <circle cx="125" cy="25" r="20" fill="#f0f0f0" />
                  <rect x="105" y="15" width="20" height="20" fill="#333" />
                  <rect x="115" y="5" width="10" height="10" fill="#333" />
                  <circle cx="75" cy="25" r="10" fill="#333" />
                  <circle cx="67" cy="17" r="2" fill="#fff" />
                  <circle cx="83" cy="17" r="2" fill="#fff" />
                  <rect x="60" y="30" width="30" height="3" fill="#fff" rx="1" ry="1" />
                  <rect x="60" y="35" width="30" height="3" fill="#fff" rx="1" ry="1" />
                  <rect x="60" y="40" width="30" height="3" fill="#fff" rx="1" ry="1" />
                  <text x="75" y="48" text-anchor="middle" font-size="12" fill="#333">COVID-19</text>
                </svg>
			</a>
			<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
				<span class="navbar-toggler-icon"></span>
			</button>
			<div class="collapse navbar-collapse" id="navbarNav">
				<ul class="navbar-nav ml-auto">
					<li class="nav-item">
						<a class="nav-link" href="#">Accueil</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="#">Services</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="#">Contact</a>
					</li>
				</ul>
			</div>
		</div>
	</nav>
	
	<!-- Div pour le graphique de ligne -->
	<div class="chart-container container mt-5">
		<canvas id="myChart"></canvas>
	</div>
	<script>
		// Code pour créer le graphique de ligne
		var ctx = document.getElementById('myChart').getContext('2d');
		var myChart = new Chart(ctx, {
			type: 'line',
			data: {
				labels: <?= $graphAbcsisses ?>,
				datasets: [{
					label: 'Morts cumulées',
					data:  <?= $graphOrdonnees ?>,
					backgroundColor: 'rgba(255, 99, 132, 0.2)',
					borderColor: 'rgba(255, 99, 132, 1)',
					borderWidth: 3
				}]
			},
			options: {
				scales: {
					yAxes: [{
						ticks: {
							beginAtZero: true
						}
					}]
				}
			}
		});
	</script>

	<div class="footer">
		<div class="row">
			<div class="col-sm-4">
				<h5>Adresse</h5>
				<p>123 Rue de la Paix<br>75008 Paris</p>
			</div>
			<div class="col-sm-4">
				<h5>Contact</h5>
				<p>Téléphone : +33 1 23 45 67 89<br>Email : contact@exemple.com</p>
			</div>
			<div class="col-sm-4">
				<h5>Suivez-nous</h5>
				<a href="#" class="btn btn-primary"><i class="fab fa-facebook-f"></i></a>
				<a href="#" class="btn btn-info"><i class="fab fa-twitter"></i></a>
				<a href="#" class="btn btn-danger"><i class="fab fa-youtube"></i></a>
			</div>
		</div>
	</div>
</body>
</html>
