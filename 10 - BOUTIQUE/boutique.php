<?php 
require_once("./include/init.php");







require_once("./include/header.php");
?>


  <!-- Page Content -->
  <div class="container">

    <div class="row">

      <div class="col-lg-3">

        <h1 class="my-4">Boutique</h1>
        <div class="list-group">
          <a href="?public=m" class="list-group-item">Homme</a>
          <a href="?public=f" class="list-group-item">Femme</a>
          <a href="?public=mixte" class="list-group-item">Mixte</a>
        </div>

      </div>
      <!-- /.col-lg-3 -->

      <div class="col-lg-9">

        <div id="carouselExampleIndicators" class="carousel slide my-4" data-ride="carousel">
          <ol class="carousel-indicators">
            <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
            <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
            <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
          </ol>
          <div class="carousel-inner" role="listbox">
            <div class="carousel-item active">
              <img class="d-block img-fluid" src="https://vignette.wikia.nocookie.net/encycopedia-anime/images/d/d9/Banni%C3%A8re_naruto.jpg/revision/latest?cb=20131214183727&path-prefix=fr" alt="First slide">
            </div>
            <div class="carousel-item">
              <img class="d-block img-fluid" src="http://www.guide-hotels-paris.fr/wp-content/uploads/2014/09/paris1.jpg" alt="Second slide">
            </div>
            <div class="carousel-item">
              <img class="d-block img-fluid" src="https://www.alexandre-dony.com/upload/modules/news/img/10/min3-1.jpg" alt="Third slide">
            </div>
          </div>
          <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
          </a>
          <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
          </a>
        </div>

        <div class="row">

        <?php 


// CATEGORIE MASCULIN
if($_GET){
if(isset($_GET['public'])){
    $recup = $bdd->prepare("SELECT photo, titre, description, prix, public, id_produit FROM produit WHERE public = :public");
    $recup->bindValue(":public", $_GET['public'], PDO::PARAM_STR);
    $recup->execute();
    $donne = $recup->fetchAll(PDO::FETCH_ASSOC);


    foreach($donne as $valeur){

            //echo"$key : $value<br>";
            extract($valeur);
            echo'<div class="col-lg-4 col-md-6 mb-4">
                <div class="card h-100">
                  <a href="#"><img class="card-img-top" src="'.$photo.'" alt=""></a>
                  <div class="card-body">
                    <h4 class="card-title">
                      <a href="fiche_produit.php?id_produit='.$id_produit.'">'.$titre.'</a>
                    </h4>
                    <h5>'.$prix.' €</h5>
                    <p class="card-text">'.$description.'</p>
                  </div>
                  <div class="card-footer">
                    <small class="text-muted">&#9733; &#9733; &#9733; &#9733; &#9734;</small>
                  </div>
                </div>
              </div><br>';
        }
    
    }
    echo "<a href='http://localhost/PHP/10%20-%20BOUTIQUE/boutique.php' class='btn btn-dark'>RETOUR A TOUTE LA BOUTIQUE</a>";
    }
    else{


    $recup = $bdd->query("SELECT photo, titre, description, prix, public, id_produit FROM produit");
    $donne = $recup->fetchAll(PDO::FETCH_ASSOC);
    //echo"<pre>";print_r($donne);echo"</pre>";
    
    //extract($donne);
    foreach($donne as $valeur){

        //echo"$key : $value<br>";
        extract($valeur);
        echo'<div class="col-lg-4 col-md-6 mb-4">
            <div class="card h-100">
              <a href="#"><img class="card-img-top" src="'.$photo.'" alt=""></a>
              <div class="card-body">
                <h4 class="card-title">
                  <a href="fiche_produit.php?id_produit='.$id_produit.'">'.$titre.'</a>
                </h4>
                <h5>'.$prix.' €</h5>
                <p class="card-text">'.$description.'</p>
              </div>
              <div class="card-footer">
                <small class="text-muted">&#9733; &#9733; &#9733; &#9733; &#9734;</small>
              </div>
            </div>
          </div>';
    
}
}
?>
<!--
          <div class="col-lg-4 col-md-6 mb-4">
            <div class="card h-100">
              <a href="#"><img class="card-img-top" src="http://placehold.it/700x400" alt=""></a>
              <div class="card-body">
                <h4 class="card-title">
                  <a href="#">Item Two</a>
                </h4>
                <h5>$24.99</h5>
                <p class="card-text">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Amet numquam aspernatur! Lorem ipsum dolor sit amet.</p>
              </div>
              <div class="card-footer">
                <small class="text-muted">&#9733; &#9733; &#9733; &#9733; &#9734;</small>
              </div>
            </div>
          </div>

-->
        </div>
        <!-- /.row -->

      </div>
      <!-- /.col-lg-9 -->

    </div>
    <!-- /.row -->

  </div>
  <!-- /.container -->




<?php 
require_once("./include/footer.php")
?>