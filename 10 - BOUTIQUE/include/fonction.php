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

?>