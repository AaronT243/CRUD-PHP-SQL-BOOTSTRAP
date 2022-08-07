<?php
/*une session pour chaque action (edit et delete) un message sera aficher pour ces 2 actions et l'utilisateur dirigé vers 
la page dediée pour chaque action */ 

session_start();

// connection à la base de données 
$mysqli = new mysqli('localhost','root','root','crud') or die(mysqli_error($mysqli));
$id = 0;
$update = false; // la valeur par defaut de update est false
$nom = '';
$adresse ='';
// verifier si les champs sont actionnés
if (isset($_POST['ENVOYER'])){
    $nom= $_POST['nom'];
    $adresse=$_POST['adresse'];

    // la session (afficher le message d'ajout d'un élément)
    $_SESSION['message'] = "Elément ajouté!";
    $_SESSION['msg_type'] = "Succé!";

    header('location: index.php');
    // et ensuite inserer les données entrées par l'utilisateurs dans la table data 
    $mysqli ->query("INSERT INTO data (nom, adresse) VALUES('$nom','$adresse')") or die($mysqli->error);
}
// supprimer les élements d'un utilisateurs grace au button delete
if(isset($_GET['delete'])){
    $id= $_GET['delete'];
    $mysqli->query("DELETE FROM data WHERE id=$id") or die($mysqli->error());

     // la session (afficher le message de la suppression d'un élément)
     $_SESSION['message'] = "Elément supprimé!";
     $_SESSION['msg_type'] = "Supprimé!";

     header('location: index.php');
}
// modifier les elements ou les valeurs d'un utilisateur 
if (isset($_GET['edit'])){
    $id = $_GET['edit'];
    $update = true; // variable qui permet de modifier le boutton edit en (update)
    $result = $mysqli->query("SELECT* FROM data WHERE id=$id") or die($mysqli->error());
    if(count($result)==1){
        $row = $result ->fetch_array();
        $nom = $row['nom'];
        $adresse = $row['adresse'];

    }
}
// verifier si le boutton (update a été actionné pour pouvoir modifier les elements dans les champs)
if (isset($_POST['update'])){
    $id = $_POST['id'];
    $nom = $_POST['nom'];
    $adresse = $_POST['adresse'];

    $mysqli->query("UPDATE data SET nom='$nom', adresse='$adresse' WHERE id=$id") or die($mysqli->error);

    // mettre une sesion pour envoyer un message apres avoir (update) modifié les elements
    $_SESSION['message'] = "éléments modifiés";
    $_SESSION['msg_type'] = "warning";
     // redirection de page apres action 
     header('location: index.php');
}

?>