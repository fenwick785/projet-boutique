<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta http-equiv="X-UA-Compatible" content="ie=edge">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.8.2/css/all.min.css">
<link rel="stylesheet" href="<?= URL ?>include/CSS/style.css">
<title>Title</title>
</head>
<body>




<div class="container">
<nav class="navbar navbar-expand-md navbar-dark bg-dark">
  <a class="navbar-brand" href="#">Ma boutique</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExample04" aria-controls="navbarsExample04" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarsExample04">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item active">
        <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
<?php
if(!isset($_SESSION["membre"])){
      echo '</li>
        <a class="nav-link" href="' .URL .  'inscription.php">Inscription</a>
      </li>';}

 if(!isset($_SESSION["membre"])){

    echo'  <li class="nav-item">
        <a class="nav-link" href="' .URL .  'connexion.php">Connexion</a>
      </li>';}
?>


      <li class="nav-item">
        <a class="nav-link" href="<?php URL ?>boutique.php">Boutique</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="<?php URL ?>panier.php">Panier</a>
      </li>


      <?php
      if(isset($_SESSION["membre"])){
        echo '<li class="nav-item">
        <a class="nav-link" href="' .URL.  'connexion.php?action=deconnexion">deconnexion</a>
      </li>'  ;  
}
      
      
      if(isset($_SESSION["membre"])){
        extract($_SESSION["membre"]);
        echo "<li class='nav-item'>
        <a class='nav-link' href='profil.php'>$pseudo</a>
      </li>";
      }
      
      ?>

      <?php 
      if($_SESSION){
        if($_SESSION["membre"]["statut"] == 1){
          echo '
           <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="dropdown04" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">BACK OFFICE</a>
        <div class="dropdown-menu" aria-labelledby="dropdown04">
          <a class="dropdown-item" href="' .URL .  'admin/gestion_boutique.php">Gestion boutique</a>
          <a class="dropdown-item" href="' .URL .  'admin/gestion_membre.php">Gestion membre</a>
          <a class="dropdown-item" href="' .URL .  'admin/gestion_commande.php">Gestion commande</a>
        </div>
      </li>
          ';
        }
      }
      ?>
    </ul>
    <form class="form-inline my-2 my-md-0">
      <input class="form-control" type="text" placeholder="Search">
    </form>
  </div>
</nav>
