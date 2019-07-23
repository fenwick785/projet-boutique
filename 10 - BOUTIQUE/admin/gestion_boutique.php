<?php
require_once("../include/init.php");
require_once("../include/fonction.php");

//--------------- VERIFICATION ADMIN
// si l'utilisateur n'est pas connecté et n'est pas admin il est redirigé vers 'connexion.php'
if(!internauteEstConnecteEtEstAdmin()){
    header("location: ".URL."connexion.php");
}


// ------------------ ENREGISTREMENT PRODUIT


extract($_POST);
if($_POST){
   //echo'<pre>';print_r($_POST);echo'</pre>';
   //echo'<pre>';print_r($_FILES);echo'</pre>';

    $photo_bdd="";

    if(!empty($_FILES['photo']['name'])){
        $nom_photo = $reference. '-' .$_FILES['photo']['name'];
       // echo $nom_photo;

        $photo_bdd = URL . "photo/$nom_photo";
       // echo $photo_bdd.'<hr>';

        $photo_dossier = RACINE_SITE . "photo/$nom_photo";
       // echo $photo_dossier.'<hr>';

        copy($_FILES['photo']['tmp_name'], $photo_dossier);
    }


$result = $bdd->prepare("INSERT INTO produit (reference, categorie, titre, description, couleur, taille, public, photo, prix, stock)VALUES(:reference, :categorie, :titre, :description, :couleur, :taille, :public, :photo, :prix, :stock)");
/*
$result->bindValue(':reference', $reference, PDO::PARAM_INT);
$result->bindValue(':categorie', $categorie, PDO::PARAM_INT);
$result->bindValue(':titre', $titre, PDO::PARAM_STR);
$result->bindValue(':description', $description, PDO::PARAM_STR);
$result->bindValue(':couleur', $couleur, PDO::PARAM_STR);
$result->bindValue(':taille', $taille, PDO::PARAM_STR);
$result->bindValue(':public', $public, PDO::PARAM_STR);
$result->bindValue(':photo', $photo_bdd, PDO::PARAM_STR);
$result->bindValue(':prix', $prix, PDO::PARAM_INT);
$result->bindValue(':stock', $stock, PDO::PARAM_INT);
$result->execute();
*/

foreach($_POST as $key => $value){
  if(gettype($value)=="string"){
    $type = PDO::PARAM_STR;
  }
  else {
    $type = PDO::PARAM_INT;
  }
  $result->bindValue(":$key",$value,$type);
}
$result->bindValue(":photo", $photo_bdd, PDO::PARAM_STR);
$result->execute();

$msg .= "<div class='col-md-4 mx-auto alert alert-success text-center'> Le produit <strong>$reference</strong> a bien été enregistré</div>";

}

require_once("../include/header.php");

// ------------ SUPPRESSION PRODUIT -----------------
if(isset($_GET['action']) && $_GET['action'] == "supression"){
  $delete = $bdd->exec("DELETE FROM produit WHERE id_produit = $_GET[id_produit]");
  //echo "<pre>"; print_r($_GET);echo"</pre>";
  header("location:". URL ."admin/gestion_boutique.php?action=affichage");
}

if(isset($_GET['action']) && $_GET ['action'] == "modification"){
  header("location:". URL ."admin/gestion_boutique.php?action=ajout&id_produit=$_GET[id_produit]");
}


?>

<!--
  Aficher la table des produits sous forme de tableau avec en plus une colonne 'modif' et 'supprimer'
 -->

<?php

$produit =$bdd->query("SELECT * FROM produit");
$bdd_prod = $produit->fetchAll(PDO::FETCH_ASSOC);
//echo"<pre>";print_r($bdd_prod);echo"</pre>";


foreach($bdd_prod as $key => $value){
  //echo "<div>";
  foreach($value as $key2 => $valeur){
    //echo"$key2 : $valeur<br>";
  }
  //echo"</div><hr>";
}

// ---------------------------- LIENS PRODUITS ------------------------
?>
<br><br>
<ul class="list-group col-md-4 mx-auto">
  <li class="list-group-item text-center bg-secondary text-white">BACK OFFICE</li>
  <li class="list-group-item"><a href="?action=affichage" class="text-dark">Affichage produit</a></li>
  <li class="list-group-item"><a href="?action=ajout" class="text-dark">Ajout Produit</a></li>
</ul>
<br><br>


<h2 class="display-4 text-center">GESTION BOUTIQUE</h2><hr><br>

<!-- 
    ------------------ DEBUT FICHE PRODUIT --------------------------
-->

<?php 
if(isset($_GET['action']) && $_GET['action'] == "affichage"):

?>



<h3 class="display-4 text-center">Affichage des produits</h3><hr>
<p class="text-center">Nombre de produit dans la boutique : <span class="badge badge-danger"><?= $produit->rowCount() ?></span></p>


<?="<br>".$msg."<br>"; ?>

<table class="table table-border text-center">
  <thead>
    <tr>
      <?php 
        foreach($value as $key2 => $valeur){
          echo "<th>".strtoupper($key2)."</th>";
        }
      ?>
      <th>EDDIT</th>
      <Th>SUPPRIMER</Th>
    </tr>
  </thead>
  <tbody>
    <?php
    foreach($bdd_prod as $key => $value){
      echo"<tr>";
      foreach($value as $key2 => $valeur){
        if($key2 == "photo"){
          echo "<td><img src='".$valeur."'></td>";
        }
        else{
        echo "<td>$valeur</td>";
        }
      }
      echo"<td><a href='?action=modification&id_produit=$value[id_produit]'><i class='fas fa-file-invoice'></i></a></td>
          <td><a href='?action=supression&id_produit=$value[id_produit]'><i class='far fa-trash-alt'></i></a></td>
          </tr>";
    }
    ?>
    
  </tbody>
</table>
  <?php endif; ?>
<br>
<!-- 
    ------------------ FIN FICHE PRODUIT --------------------------
-->

<!--
    ----------------- DEBUT FORMULAIRE ----------------------------
 -->

  <?php 
    if(isset($_GET['action']) && $_GET['action'] == "ajout" || $_GET['action']=='modification'):

      if(isset($_GET['id_produit'])) // on contrôle que l'indice 'id_produit' a bien été envoyé dans l'URL, cela veut dire que l'on a cliqué sur le bouton modification
      {
          $result = $bdd->prepare("SELECT * FROM produit WHERE id_produit = :id_produit");
          $result->bindValue('id_produit', $_GET['id_produit'], PDO::PARAM_INT);
          $result->execute();
          //echo '<pre>'; print_r($result); echo '</pre>';
  
          $produit_actuel = $result->fetch(PDO::FETCH_ASSOC);
          echo '<pre>'; print_r($produit_actuel); echo '</pre>';
      }

      if(isset($_GET['action']) && ($_GET['action'] == 'modification'))
      {
          foreach($produit_actuel as $key => $value)
          {
              $$key = (isset($produit_actuel[$key])) ? $produit_actuel[$key] : '';
              // 1er tour de boucle
              // $id_produit = (isset($produit_actuel['id_produit'])) ? $produit_actuel['id_produit'] : '';
              // 2ème tour de boucle 
              // $reference = (isset($produit_actuel['reference'])) ? $produit_actuel['reference'] : '';
              // etc....
              // on crée un variable par tour de boucle foreach
          }
      }
  ?>
<h3 class="display-4 text-center">Ajout de produit</h3><hr>
<br>

<form method="POST" class="col-md-6 offset-md-3" enctype="multipart/form-data">

<div class="form-group">
   <label for="inputAddress">reference</label>
   <input type="number" class="form-control" id="inputAddress" placeholder="reference" name="reference" value="<?php if(isset($reference)) echo $reference; ?>">
 </div>

 <div class="form-group">
   <label for="exampleInputEmail1">catégorie</label>
   <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="categorie" name="categorie" value="<?php if(isset($categorie)) echo $categorie; ?>">
 </div>

 <div class="form-group">
   <label for="exampleInputPassword1">titre</label>
   <input type="text" class="form-control" id="exampleInputPassword1" placeholder="titre" name="titre" value="<?php if(isset($titre)) echo $titre; ?>">
 </div>

 <div class="form-group">
   <label for="exampleInputEmail1">description</label>
   <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="description" name="description" value="<?php if(isset($description)) echo $description; ?>">
 </div>


<div class="form-group">
   <label for="exampleInputPassword1">couleur</label>
   <input type="text" class="form-control" id="exampleInputPassword1" placeholder="couleur" name="couleur" value="<?php if(isset($couleur)) echo $couleur; ?>">
 </div>


 <div class="form-group">
   <label for="exampleInputPassword1">taille</label>
   <input type="text" class="form-control" id="exampleInputPassword1" placeholder="taille" name="taille" value="<?php if(isset($taille)) echo $taille; ?>">
 </div>

<br>
 <div class="form-check form-check-inline">public      :
 <input class="form-check-input" type="radio" id="inlineCheckbox1" name="public" value="m">
 <label class="form-check-label" for="inlineCheckbox1">masculin</label>
</div>
<div class="form-check form-check-inline">
 <input class="form-check-input" type="radio" id="inlineCheckbox2" name="public" value="f">
 <label class="form-check-label" for="inlineCheckbox2">féminin</label>
</div>
<div class="form-check form-check-inline">
 <input class="form-check-input" type="radio" id="inlineCheckbox2" name="public" value="mixte">
 <label class="form-check-label" for="inlineCheckbox2">mixte</label>
</div>


<br>

<div class="form-group">
    <label for="photo">Photo</label>
    <input type="file" class="form-control" id="photo" name="photo">
</div>



<div class="form-group">
   <label for="inputAddress">prix</label>
   <input type="number" class="form-control" id="inputAddress" placeholder="prix" name="prix" value="<?php if(isset($prix)) echo $prix; ?>">
 </div>

 <div class="form-group">
   <label for="inputAddress">stock</label>
   <input type="number" class="form-control" id="inputAddress" placeholder="stock" name="stock" value="<?php if(isset($stock)) echo $stock; ?>">
 </div>
<br>


 <button type="submit" class="btn btn-dark col-md-12">ajouter</button>
 <br>
</form>
<br>
 <?php endif; ?>
<?php
require_once("../include/footer.php")
?>