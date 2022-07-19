<?php

// on crée une connexion bdd
$host = 'mysql:host=localhost;dbname=localite';
$login = 'root';
$password = '';
$options = array(
    PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING,
    PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
);

$pdo = new PDO($host, $login, $password, $options);


$tab = array();
$tab['resultat'] = '';
$tab['resultat_list'] = '';


if (isset($_POST['region_code'])) {
    $region_code = $_POST['region_code'];

    $req = $pdo->prepare("SELECT * FROM departments WHERE region_code = :region_code ORDER BY name");
    $req->bindParam(':region_code', $region_code, PDO::PARAM_STR);
    $req->execute();

    $list = $req->fetchAll(PDO::FETCH_ASSOC);

    $tab['resultat'] .= '<option selected disabled>Merci de choisir un département</option>';

    foreach ($list as $sous_tableau) {
        $tab['resultat'] .= '<option value="' . $sous_tableau['code'] . '">' . $sous_tableau['name'] . '</option>';
    }
}


// nouveau if pour récupérer les villes selon le departement
if (isset($_POST['department_code'])) {
    $department_code = $_POST['department_code'];

    $req = $pdo->prepare("SELECT * FROM villes WHERE department_code = :department_code ORDER BY name");
    $req->bindParam(':department_code', $department_code, PDO::PARAM_STR);
    $req->execute();

    $tab['resultat_list'] = '<ul class="list-group">';

    while($ligne = $req->fetch(PDO::FETCH_ASSOC)) {
        $tab['resultat'] .= '<option value="' . $ligne['zip_code'] . '">' . $ligne['zip_code'] . ' - ' . $ligne['name'] . '</option>';
        $tab['resultat_list'] .= '<li class="list-group-item">' . $ligne['zip_code'] . ' - ' . $ligne['name'] . '</li>';
    }
}

echo json_encode($tab);
