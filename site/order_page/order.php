<?php
require_once("db_connect.php");
require("function.php");
//isAdmin();

if ($_SERVER["REQUEST_METHOD"] == "POST") $method = $_POST;
else $method = $_GET;

switch($method['opt']){


    // - selection de commande par id : parmet de voir les commande selon l'id client
    // - vérification de l'id user ou l'id sneakers
    case 'select_users_id':
        if (isset($_SESSION["users_id"])){
            $req=$db->prepare("SELECT * from orders where users_id =  ?");
            $req->execute([$_SESSION["users_id"]]);
            $order=$req->fetch(PDO::FETCH_ASSOC);
            echo json_encode(['sucess'=>true,'order'=>$order]);
        }else{
            echo json_encode(['sucess'=>false,'msg'=>"pas de commande avec cette id"]);
        }

    break;

    case 'select_num':
        if (isset($_POST["number_order"])){
            $req=$db->prepare("SELECT * from orders where number_order =  ?");
            $req->execute([$_POST["number_order"]]);
            $order=$req->fetch(PDO::FETCH_ASSOC);
            echo json_encode(['sucess'=>true,'order'=>$order]);
        }else{
            echo json_encode(['sucess'=>false,'msg'=>"pas de commande avec cette id"]);
        }

    break;

    // insertion 
    case 'insert':
        //print_r($_POST);
        //print_r($_SESSION);
        if(isset($_POST["etat_c"],$_POST["date_de_commande"],$_SESSION["users_id"],$_POST["id_sneakers"]) && !empty(trim($_POST["etat_c"]) && !empty(trim($_POST["date_de_commande"])) && !empty(trim($_SESSION["users_id"])) && !empty(trim($_POST["id_sneakers"])))){
            $req=$db->prepare("INSERT INTO orders (etat_c,date_de_commande,users_id,id_sneakers) VALUES (:etat_c,:date_de_commande,:users_id,:id_sneakers)");
            $req->bindValue(":etat_c",$_POST["etat_c"]);
            $req->bindValue(":date_de_commande",$_POST["date_de_commande"]);
            $req->bindValue(":users_id",$_SESSION["users_id"]);
            $req->bindValue(":id_sneakers",$_POST["id_sneakers"]);
            $req->execute();
            echo json_encode(["sucess"=>true,"msg"=>"commande ajouter"]);
        }else{
            echo json_encode(["sucess"=>false,"msg"=>"champs non renseigner"]);
        }
    break;

    default:
        echo json_encode(["sucess"=>false, "msg"=>"demande inconnu"]);

}