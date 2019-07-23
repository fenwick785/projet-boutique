<?php
require_once("./include/init.php");
require_once("./include/header.php");
?>
<!-- 
    1. Realiser un formulaire d'inscription qui correspond a la table 'membre' de la BDD 'site' (sauf id_membre et statut)
    2. controler en PHP que l'on receptionne bien toute les données du formulaire
    3. controler la validité du pseudo et de l'email
 -->
<?php
extract($_POST);
if($_POST){
    //echo'<pre>';print_r($_POST); echo'<pre>';
    $verif = $bdd->prepare("SELECT *FROM membre WHERE pseudo = :pseudo || email = :email");
$verif->bindValue(':pseudo',$pseudo, PDO::PARAM_STR);
$verif->bindValue(':email', $email, PDO::PARAM_STR);
$verif->execute();

if($verif->rowCount()>0){
    $error .= '<div class="col-md-6 offset-md-3 alert alert-danger text-center"><strong>Un compte est déja éxistant</strong></div>';
}
if($mdp != $confirm_mdp){
    $error .= '<div class="col-md-6 offset-md-3 alert alert-danger text-center"><strong>mot de passe non identique</strong></div>';
}

if(!$error){

    $mdp = password_hash($mdp, PASSWORD_DEFAULT); // on ne conserve jamais le mot de passe en clair dans la BDD
    // password_hash() permet de créer une clef hachage

    $envoie = $bdd->prepare("INSERT INTO membre (pseudo, mdp, nom, prenom, email, civilite, code_postale, adresse, ville) VALUES (:pseudo,:mdp,:nom,:prenom,:email,:civilite,:code_postale,:adresse,:ville)");
    $envoie->bindValue(':pseudo', $pseudo, PDO::PARAM_STR);
    $envoie->bindValue(':mdp', $mdp, PDO::PARAM_STR);
    $envoie->bindValue(':nom', $nom, PDO::PARAM_STR);
    $envoie->bindValue(':prenom', $prenom, PDO::PARAM_STR);
    $envoie->bindValue(':email', $email, PDO::PARAM_STR);
    $envoie->bindValue(':civilite', $civilite, PDO::PARAM_STR);
    $envoie->bindValue(':ville', $ville, PDO::PARAM_STR);
    $envoie->bindValue(':code_postale', $code_postale, PDO::PARAM_INT);
    $envoie->bindValue(':adresse', $adresse, PDO::PARAM_STR);
    $envoie->execute();
    header("location:".URL."connexion.php?inscription=valid");




/*
//AUTRE FACON DE FAIRE EN BOUCLANT LE TABLEAU $_POST avec $key qui définie la varable de chaque champ
if(!$error){
    $envoie = $bdd->prepare("INSERT INTO membre (pseudo, mdp, nom, prenom, email, civilite, code_postale, adresse, ville) VALUES (:pseudo,:mdp,:nom,:prenom,:email,:civilite,:code_postale,:adresse,:ville)");
    
        foreach($_POST as $key => $value){
            if($key != 'cofirm_mdp'){
                $envoie->bindValue(':key', $key);
            }
        }
    $envoie->execute();

}
*/
}
}


?>


 <!-- FORMULAIRE -->
 <h2 class="display-4 text-center">Inscription</h2><hr>

<?= $error ?>

 <form method="POST" class="col-md-6 offset-md-3">

 <div class="form-group">
    <label for="inputAddress">pseudo</label>
    <input type="text" class="form-control" id="inputAddress" placeholder="pseudo" name="pseudo">
  </div>

  <div class="form-group">
    <label for="exampleInputEmail1">Email address</label>
    <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter email" name="email">
  </div>

  <div class="form-group">
    <label for="exampleInputPassword1">Password</label>
    <input type="password" class="form-control" id="exampleInputPassword1" placeholder="Password" name="mdp">
  </div>

  <div class="form-group">
    <label for="exampleInputPassword1">Confirm Password</label>
    <input type="password" class="form-control" id="exampleInputPassword1" placeholder="Confirm Password" name="confirm_mdp">
  </div>

  <div class="row">
    <div class="col">prenom :
      <input type="text" class="form-control" placeholder="prenom" name="prenom">
    </div>
    <div class="col">nom :
      <input type="text" class="form-control" placeholder="nom" name="nom">
    </div>
  </div>
<br>
  <div class="form-check form-check-inline">
  <input class="form-check-input" type="radio" id="inlineCheckbox1" name="civilite" value="m">
  <label class="form-check-label" for="inlineCheckbox1">masculin</label>
</div>
<div class="form-check form-check-inline">
  <input class="form-check-input" type="radio" id="inlineCheckbox2" name="civilite" value="f">
  <label class="form-check-label" for="inlineCheckbox2">féminin</label>
</div>
<br>
<div class="form-group">
    <label for="inputAddress">Adresse</label>
    <input type="text" class="form-control" id="inputAddress" placeholder="adresse" name="adresse">
  </div>

  <div class="form-group">
    <label for="inputAddress">Code postal</label>
    <input type="number" class="form-control" id="inputAddress" placeholder="code postal" name="code_postale">
  </div>

  <div class="form-group">
    <label for="inputAddress">ville</label>
    <input type="text" class="form-control" id="inputAddress" placeholder="ville" name="ville">
  </div>

  <button type="submit" class="btn btn-dark col-md-12">Submit</button>
  
</form>
<br>


<?php
require_once("./include/footer.php");
?>