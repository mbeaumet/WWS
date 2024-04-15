<?php
session_start();
require_once("../db_connect.php");


// if ((!isset($_POST["email"])) && (!(isset($_POST["user_name"])))) {
//         echo json_encode(["success" => false, "error" => "donnée manquant"]);
//         die;
// }

// if (!isset($_POST["pwd"]) || !empty(trim($_POST["pwd"]))){
//     echo json_encode(["success" => false, "error" => "Données manquantes"]);
//     die;
// }

// Si les éléments username_email et pwd sont rempli et non vide dans le formulaire alors le code a l'intérieur du if est alors éxécuter. 
if((isset($_POST["username_email"])) && isset($_POST["pwd"]) && !empty(trim($_POST["username_email"])) && (!empty(trim($_POST["pwd"])))){
    // requete SQL qui permet de selectionner dans la table user les données : mot de passe, l'id user et enfin si l'utilisateur est un admin.
    $req = $db->prepare("SELECT pwd,users_id,admin FROM users WHERE email=? OR user_name=?"); 
    // execution de la requète sql preparer avec la récuperation des données du formulaire. Ceci permettra de voir si les données formulaire existe dans la base de donnée. 
    $req->execute([$_POST["username_email"],$_POST["username_email"]]);
    // Permet de récuperer l'ensemble des infos de la requète
    $user = $req->fetch(PDO::FETCH_ASSOC);

    // Si la variable user est non vide et que le mot de passe de la base de donnée est le même que celui entrer dans le formulaire alors le code a l'intérieur du if est executés.
    if ($user && password_verify($_POST["pwd"], $user["pwd"])) {
        // Cette ligne permet de passer la valeur de connecter à true pour savoir si l'utilisateur est bien connecter.
        $_SESSION["connected"] = true;
        // Je passe la variable id de l'utilisateur de la session à la valeur de l'id de l'utilisateur
        $_SESSION["users_id"] = $user["users_id"];
        // Je passe la variable admin à la valeur de l'utilisateur qui se connecte soit 0 ou 1. 
        $_SESSION["admin"] = $user["admin"];

        unset($user["pwd"]);

        // Renvoi un message de success a true
        echo json_encode(["success" => true, "user" => $user]);
        die;
    } else {
        echo json_encode(["success"=>false, "error"=>"mot de passe érroné"]);
    }
} else {
    $_SESSION = [];
    echo json_encode(["success" => false, "error" => "donnée manquante"]);
} 