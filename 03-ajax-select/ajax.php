<?php

// on crée une connexion bdd
$host = 'mysql:host=localhost;dbname=entreprise';
$login = 'root';
$password = '';
$options = array(
    PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING,
    PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
);

$pdo = new PDO($host, $login, $password, $options);


$tab = array();
$tab['resultat'] = '';

if(isset($_POST['service'])) {
    $service = $_POST['service'];

    // $req = $pdo->prepare("SELECT * FROM employes WHERE service = ? ORDER BY nom");
    $req = $pdo->prepare("SELECT * FROM employes WHERE service = :service ORDER BY nom"); // :service est un marqueur nominatif
    $req->bindParam(':service', $service, PDO::PARAM_STR);
    $req->execute();

    /*
    // Autre possibilité d'écriture
    $param = array(':service' => $service);
    $req = $pdo->prepare("SELECT * FROM employes WHERE service = :service ORDER BY nom"); // :service est un marqueur nominatif
    $req->execute($param);
    */

    /*
    // Autre possibilité d'écriture
    $req = $pdo->prepare("SELECT * FROM employes WHERE service = ? ORDER BY nom"); // :service est un marqueur nominatif
    $req->execute([$service]);
    */

    $liste = $req->fetchAll(PDO::FETCH_ASSOC);
    $tab['resultat'] .= '<ul class="list-group bg-light">';
    foreach($liste AS $sous_tableau) {
        $tab['resultat'] .= '<li class="list-group-item">' . ucfirst($sous_tableau['nom']) . ' ' . ucfirst($sous_tableau['prenom']) . ' et la date d\'embauche est le :  ' . $sous_tableau['date_embauche'] . '</li>' ;
    }
    $tab['resultat'] .= '</ul>';


}

echo json_encode($tab);
