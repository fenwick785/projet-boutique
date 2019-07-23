<?php
//  -------------------- CONNEXION BDD ------------------------------- //
$bdd = new PDO('mysql:host=localhost;dbname=site', 'root', '', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING, PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'));

// -------------- SESSION ---------------- //
session_start();

// -------------- CHEMIN ------------- //
define("RACINE_SITE",$_SERVER['DOCUMENT_ROOT']."/PHP/10 - BOUTIQUE/");
//echo RACINE_SITE;
// cette constante retourne le chemin physique du dossier 10-boutique sur le serveur 
// lors de l'enregistrement d'image/photos, nous aurons besoins du chemin complet de dossier photo afin d'enregistrer la photo dans le bon dossier

define("URL", "http://localhost/PHP/10%20-%20BOUTIQUE/");
// echo URL;
// cette constante servira par exemple a enregistrer l'URL des images/photos dans la BDD;
// on ne conserve jamais la photo elle meme, ça serai trop lours pour la BDD

//------------- VARIABLE ------------------ //
$content ="";
$error = "";
$msg = "";

// ------------ FAILLES XSS ------------- //
foreach($_POST as $key => $value){
    $_POST[$key] = strip_tags(trim($value));
}
// strip_tags() : supprime les balises HTML
// trim () : supprime les espaces en début et fin de chaine

// ---------------- INCLUSION ----------- //
//require_once("./fonction.php");
// en appelant le fichier init.php on appel dans le même temps le fichier fonction.php
?>