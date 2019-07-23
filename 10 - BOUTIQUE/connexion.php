<?php


require_once("./include/fonction.php");
require_once("./include/init.php");
require_once("./include/header.php");
if(isset($_GET['inscription']) && $_GET['inscription'] == 'valid'){
    $content .='<div class="col-md-6 offset-md-3 alert alert-success text-center"><strong>Vous êtes maintenant inscrit sur notre site !!</strong></div>';
}
extract($_POST);

// si l'internaute est est connecté, il n'a plus accès a la page connexion => il est redirigé vers la page profil.php

if(internauteEstConnecte()){
  header("location:".URL."profil.php");
}



if($_POST){
  $verif = $bdd->prepare("SELECT*FROM membre WHERE email = :email || pseudo = :pseudo");
  $verif->bindValue(':pseudo',$pseudo_email, PDO::PARAM_STR);
  $verif->bindValue(':email',$pseudo_email, PDO::PARAM_STR);
  $verif->execute();

  if($verif->rowCount()>0){
    $membre = $verif->fetch(PDO::FETCH_ASSOC);
    //echo'<pre>';print_r($membre);echo'</pre>';
    if(password_verify($mdp, $membre['mdp'])){ //=> Dans le cas ou les mot de passes ont été hashé
      //if($membre["mdp"]==$mdp){
        //echo"mdp : ok";
        foreach ($membre as $key => $value) {
          if($key != 'mdp'){
            $_SESSION['membre'][$key]=$value;
          }
        }
        //echo'<pre>';print_r($_SESSION);echo'<pre>';
        header("location:".URL."profil.php");
      }
      else {
        $error .= '<div class="col-md-6 offset-md-3 alert alert-danger text-center">Mot de passe incorrect</div>';
      }
  }
  else{
    $error .= '<div class="col-md-6 offset-md-3 alert alert-danger text-center">Pseudo / Email inexistant</div>';
  }
}
if(isset($_GET['action']) && $_GET['action']=='deconnexion'){
  session_destroy();
}

?>

<h2 class="display-4 text-center">connexion</h2><hr>
<?= $content ?>
<form method="POST" class="col-md-6 offset-md-3">
<?= $error ?>
 <div class="form-group">
   <label for="exampleInputEmail1">Email address / pseudo</label>
   <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="pseudo / email" name="pseudo_email">
 </div>

 <div class="form-group">
   <label for="exampleInputPassword1">Password</label>
   <input type="password" class="form-control" id="exampleInputPassword1" placeholder="Password" name="mdp">
 </div>

 <button type="submit" class="btn btn-dark col-md-12">Submit</button>

</form>
<br>



<?php
require_once("./include/footer.php");
?>