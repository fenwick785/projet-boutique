<?php
// ------------------ FONCTION MEMBRE CONNECTE
function internauteEstConnecte(){
    if(!isset($_SESSION["membre"])){ // si l'indice 'membre' dans la session n'est pas définie, cela veut dire que l'internaute n'est pas passé par la page 'connexion'
        return false;
    }
    else{ // dans tout les autre cas, cela veut dire que l'internaute est passé par la page 'connexion.php' et que l'indice (tableau) 'membre' a bien été definie dans ma session
        return true;
    }
}

// ------------------ Fonction connecte et admin
function internauteEstConnecteEtEstAdmin(){
    if(internauteEstConnecte() && $_SESSION['membre']['statut']==1){ // si membre est connecté + si il est admin (statut == 1)
        return true;
    }
    else{
        return false;
    }
}

// ----------------- CREATION DU PANIER

function creationDuPanier(){ // si l'indice 'panier' n'est pas predefinie dans le fichier SESSION, c'est que l'internaute n'a pas ajouté de produit dans le panier
    if(!isset($_SESSION['panier'])){
        $_SESSION['panier'] = array(); // tableau multidimensionnel
        $_SESSION['panier']['titre'] = array();
        $_SESSION['panier']['id_produit'] = array();
        $_SESSION['panier']['quantite'] = array();
        $_SESSION['panier']['prix'] = array();
    }
}

// ------------------ ---------------------------------------------------


function ajouterProduitAuPanier($titre, $id_produit, $quantite, $prix){
    creationDuPanier(); // on controle si le panier existe dans la session

    $position_produit = array_search($id_produit, $_SESSION['panier']['id_produit']);
    // on controle grace a la fonction predefinie array_search() si l'id_produit que l'internaute vient d'ajouter au panier, si il existe deja dans la session et a quel indice il se trouve    
    if($position_produit !== false){
    // si la position du produit est differente de false, c'est a dire qu'il retourne l'indice de l'id_produit
        $_SESSION['panier']['quantite'][$position_produit] += $quantite;
        // on change la quantite a l'indice trouvé
    }
    else{
    // sinon, le produit n'existe pas dans la session, donc on stock les informations aux différents tableaux

    $_SESSION['panier']['titre'][] = $titre; 
    // [] vide permet de creer des indices numériques
    $_SESSION['panier']['id_produit'][] = $id_produit;
    $_SESSION['panier']['quantite'][] = $quantite;
    $_SESSION['panier']['prix'][] = $prix;

    }
}

// -------------------------
// FONCTION MONTANT TOTAL :
function montantTotal(){
    $total = 0;
    for($i = 0; $i < count($_SESSION['panier']['id_produit']) ; $i++){
        $total += $_SESSION['panier']['prix'][$i]*$_SESSION['panier']['quantite'][$i];
        // c'est la ligne prix total par produit
    }
    return round($total, 2); // on arrondie a 2 decimal le resultat
}


// -------------------------
function retirerProduitDuPanier($id_produit_a_supprimer){
    $position_produit = array_search($id_produit_a_supprimer, $_SESSION['panier']['id_produit']);
    // array_search() permet de trouver dans un tableau a quel indice se trouve un element du tableau

    if($position_produit !== false){ // si la variable $position_produit retourne une valeur differente de false => un indice a bien été trouvé dans la session 'panier'

        // array_splice(): elle permet de supprimer une ligne dans le tableau session, et elle remonte les indices inferieur de tableau au indice superieur du tableau, si je supprime un produit a l'indice 4, tous les produits apres l'indice 4 remonteront tous d'un indice
        // cela permet de reorganiser le tableau panier dans la session et de ne pas avoir d'indice vide
        array_splice($_SESSION['panier']['titre'], $position_produit, 1);
        array_splice($_SESSION['panier']['id_produit'], $position_produit, 1);
        array_splice($_SESSION['panier']['quantite'], $position_produit, 1);
        array_splice($_SESSION['panier']['prix'], $position_produit, 1);
    }
}

?>