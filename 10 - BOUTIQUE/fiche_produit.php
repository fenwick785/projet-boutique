<?php
require_once("./include/init.php");
require_once("./include/header.php");

if (isset($_GET['id_produit'])) {
    extract($_GET);
    
    $art = $bdd->prepare("SELECT * FROM produit WHERE id_produit = :id_produit");
    $art->bindValue(":id_produit", $_GET['id_produit'], PDO::PARAM_STR);
    $art->execute();
    $produit = $art->fetch(PDO::FETCH_ASSOC);
    //echo"<pre>";print_r($produit);echo"</pre>";
    extract($produit);
}

?>

<h3 class="display-4 text-center">FICHE PRODUIT : <?= $categorie ?></h3>
<hr>

<div class="container">

    <div class="row">

        <!-- /.col-lg-3 -->

        <div class="col-lg-12">

            <div class="card mt-4">
                <img class="card-img-top img-fluid" src="<?= $photo ?>" alt="">
                <div class="card-body">
                    <h3 class="card-title"><?= $titre ?></h3>
                    <h4><?= $prix ?> €</h4>
                    <p class="card-text"><?= $description ?></p>
                    <span class="text-warning">&#9733; &#9733; &#9733; &#9733; &#9734;</span>

                </div>
            </div>
            <!-- /.card -->

            <div class="card card-outline-secondary my-4">
                <div class="card-header">
                    + d'info
                </div>
                <div class="card-body">
                    <p>REFERENCE: <?= $reference ?></p>
                    <hr>
                    <p>COULEUR: <?= $couleur ?></p>
                    <hr>
                    <p>TAILLE: <?= $taille ?></p>
                    <hr>
                    <p>GENRE: <?php if ($public == "m"){
                                    echo "homme";
                                } elseif ($public == "f"){
                                    echo "femme";
                                }
                                else{
                                    echo"mixte";
                                } ?></p>
                    <hr>
                    <p>STOCK: <?php if ($stock > 0) {
                                    echo "IL EN RESTE";
                                } 
                                else {
                                    echo "RUPTURE DE STOCK !!";
                                } ?></p>
                    <hr>
                    <form action="panier.php" method="POST">
                        <input type="hidden" name="id_produit" value="<?= $id_produit ?>">
                        <div class="form-group">
                            <label for="exampleFormControlSelect1">Quantité souhaitée:</label>
                            <select class="form-control" id="exampleFormControlSelect1" name="quantite">
                                <?php 
                                    for($i = 0; $i <= $stock && $i <=30; $i++)
                                    {
                                        echo"<option>$i</option>";
                                    }
                                ?>
                            </select>
                        </div>
                        <button href="" type="submit" class="btn btn-success col-md-4 offset-md-4" name="ajout_panier">Ajouter au panier</button>
                    </form>
                </div>
            </div>
            <!-- /.card -->
            <a href="boutique.php" class="btn btn-danger col-md-4 offset-md-4">retour</a>
            <a href="boutique.php?public=<?= $public ?>" class="btn btn-dark col-md-4 offset-md-4">retour vers categorie</a>
        </div>
        <!-- /.col-lg-9 -->

    </div>

</div>
<!-- /.container -->


<?php require_once("./include/footer.php") ?>