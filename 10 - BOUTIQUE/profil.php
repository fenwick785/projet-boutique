<?php

require_once("./include/init.php");
require_once("./include/header.php");
require_once("./include/fonction.php");


//echo'<pre>';print_r($_SESSION);echo'<pre>';

extract($_SESSION['membre']); // seulement extract($_SESSION); on aurait seulement accès a $membre

if(!internauteEstConnecte()){ 
    header("location:".URL."connexion.php");
}


?>
<div class="col-md-5 offset-md-3">
<h2 class="display-4 text-center">Profil de <?=$pseudo?> 
<?php
if(internauteEstConnecteEtEstAdmin()){
    echo '<div class="text-danger">(ADMIN)</div>';
}
?>
</h2><hr>

<h3 class="text-center">vos coordonné :</h3><hr>

<table class="text-center">
    <tr>
      <th scope="row">adresse : </th>
      <td><?= $adresse ?></td>
    </tr>  
    <tr>
      <th scope="row">ville : </th>
      <td><?= $ville ?></td>
    </tr>  
    <tr>
      <th scope="row">code postal : </th>
      <td><?= $code_postale ?></td>
    </tr>  
    <tr>
      <th scope="row">adrese email  : </th>
      <td><?= $email ?></td>
    </tr>
</table>
<br>
<h3 class="text-center">A propos de moi :</h3><hr>

<table class="text-center">
    <tr>
      <th scope="row">Nom : </th>
      <td><?= $nom ?></td>
    </tr>  
    <tr>
      <th scope="row">Prenom : </th>
      <td><?= $prenom ?></td>
    </tr>  
    <tr>
      <th scope="row">civilité : </th>
      <td><?php
        if($civilite == 'm'){
            echo 'homme';
        }
        else{
            echo 'femme';
        }
      ?></td>
    </tr>
</table>
    <br>
        <p class="text-center btn btn-dark"><a href="#" class=" text-center">modifier le profil</a></p>
    

<br>
</div>



<?php
require_once("./include/footer.php");
?>