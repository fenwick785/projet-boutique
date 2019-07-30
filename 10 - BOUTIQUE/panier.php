<?php
require_once("./include/init.php");
require_once("./include/fonction.php");

// --------- AJOUT PANIER
if(isset($_POST['ajout_panier'])){
    extract($_POST);
    //echo"<pre>";print_r($_POST);echo"</pre>";

    $prod = $bdd->prepare("SELECT * FROM produit WHERE id_produit = :id_produit");
    $prod->bindValue(":id_produit", $id_produit, PDO::PARAM_INT);
    $prod->execute();
    $produit = $prod->fetch(PDO::FETCH_ASSOC);
    //echo"<pre>";print_r($produit);echo"</pre>";

    ajouterProduitAuPanier($produit['titre'],$produit['id_produit'],$_POST['quantite'],$produit['prix']);
}

//echo"<pre>";print_r($_SESSION);echo"</pre>";

if(isset($_POST['payer'])){
    for($i = 0 ; $i < count($_SESSION['panier']['id_produit']); $i++){
        $result = $bdd->query("SELECT * FROM produit WHERE id_produit =". $_SESSION['panier']['id_produit'][$i]); // on selectionne les infos de chaques produits ajouté au panier
        $produit = $result->fetch(PDO::FETCH_ASSOC);
        echo"<pre>";print_r($produit);echo"</pre>";

        if($produit['stock']<$_SESSION['panier']['quantite'][$i]){

            $error .= "<div class='col-md-8 offset-md-2 alert alert-danger'>STOCK RESTANT DU PRODUIT <strong> ". $_SESSION['panier']['titre'][$i]."</strong> : <strong>".$produit['stock'] . "</strong></div>";

            $error .= "<div class='col-md-8 offset-md-2 alert alert-danger'>QUANTITE DEMANDE DU PRODUIT <strong> ". $_SESSION['panier']['titre'][$i]."</strong> : <strong>".$_SESSION['panier']['quantite'][$i] . "</strong></div>";

            if($produit['stock']>0){
                $error .= "<div class='col-md-8 offset-md-2 alert alert-danger'>LA QUANTITE DU PRODUIT <strong> ". $_SESSION['panier']['titre'][$i]."</strong> A ETE REDUITE CAR NOTRE STOCK EST INSUFISANT</div>";
                $_SESSION['panier']['quantite'][$i] = $produit['stock'];
            }
            else {
                $error .= "<div class='col-md-8 offset-md-2 alert alert-danger'>LE PRODUIT <strong> ". $_SESSION['panier']['titre'][$i]."</strong> A ETE RETIRE DE VOTRE PANIER CAR NOUS SOMMES EN RDS</div>";

                retirerProduitDuPanier($_SESSION['panier']['id_produit'][$i]);
                $i--;
            }
        }
    }
    if(empty($error)){
        $result = $bdd->exec("INSERT INTO commande (membre_id, montant, date_enregistrement) VALUES (". $_SESSION['membre']['id_membre'].",".montantTotal(). ",NOW())"); // on insert les données dans la table commande

        $id_commande = $bdd->lastInsertId(); // on recupere la derniere id genere dans la table commande, nous en avons besoin pour relier chaque produit a la bonne commande dans la table detail commande

        for($i = 0; $i < count($_SESSION['panier']['id_produit']); $i++){
            $result = $bdd->exec("INSERT INTO details_commande (commande_id, id_produit, quantite, prix) VALUES ($id_commande," . $_SESSION['panier']['id_produit'][$i]. ",". $_SESSION['panier']['quantite'][$i]. ", ". $_SESSION['panier']['prix'][$i] . ")"); // pour chaque tour de boucle, on insere le detail de la commande pour chaque produit

            $result = $bdd->exec("UPDATE produit SET stock = stock - " . $_SESSION['panier']['quantite'][$i] ." WHERE id_produit=" . $_SESSION['panier']['id_produit'][$i]);
            // dépreciassion des stocks, on modifie la quantite en BDD
        }
        unset($_SESSION['panier']);
        $msg .= "<div class='col-md-8 offset-md-2 alert alert-success text-center'>COMMANDE VALIDEE !! <br>
        Votre numéro de suivi est le <strong> ". $id_commande."</strong></div>";
    }
}



require_once("./include/header.php");

/*
if(isset($_GET['action']) && $_GET['action'] == "supression"){
  $delete = $bdd->exec("DELETE FROM produit WHERE id_produit = $_GET[id_produit]");
  //echo "<pre>"; print_r($_GET);echo"</pre>";
  header("location:". URL ."panier.php");
}
*/
?>


<div class="col-md-8 offset-md-2">
    <table class="table text-center">

<?= $error ?>
<?= $msg ?>

        <tr><th colspan="5"><h2 class="dispaly-4">PANIER</h2></th></tr>
        <tr><th>Titre</th><th>quantite</th><th>prix unitaire</th><th>prix total</th><th>supprimer</th></tr>
<?php if(empty($_SESSION['panier']['id_produit'])): ?>

<div class="col-md-6 offset-md-3 alert alert-danger text-center">VOTRE PANIER EST VIDE !</div>

<?php else: ?>

    <?php for($i = 0 ; $i < count($_SESSION['panier']['id_produit']) ; $i++): ?>

    <tr>
        <td><?= $_SESSION['panier']['titre'][$i]?></td>
        <td><?= $_SESSION['panier']['quantite'][$i]?></td>
        <td><?= $_SESSION['panier']['prix'][$i]?> €</td>
        <td><?= $_SESSION['panier']['prix'][$i]*$_SESSION['panier']['quantite'][$i]?> €</td>
        <td><a href="?action=suppression&id_produit=<?= $_SESSION['panier']['id_produit'][$i] ?>"><i class='far fa-trash-alt'></i></a></td>
    </tr>
    

    <?php endfor; ?>


        <tr><th colspan="">TOTAL :</th> <th colspan="2"></th><th><?= montantTotal() ?> €</th></tr>
<?php if(internauteEstConnecte()): ?>

    <form method="post" action="">
        <tr><td colspan="5">
            <input type="submit" name="payer" class="col-md-12 btn btn-success" value="valider la commande">
        </td></tr>
    </form>

    <?php else: ?>

    <tr><td colspan="5">
            <div>Veuillez-vous <a href="<?= URL ?>connexion.php" class="alert-link text-warning">connecter</a> ou vous <a href="<?= URL ?>inscription.php" class="alert-link text-warning">inscrire</a></div>
    </td></tr>


    <?php endif; ?>

    <tr><td colspan="5"><a href="?action=vider" onclick="return(confirm('En êtes-vous certain?'))">vider mon panier</a></td></tr>

    <?php endif; ?>
    </table>
</div>



<?php 
require_once("./include/footer.php");
?>