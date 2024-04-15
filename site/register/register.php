<?php
require_once('../db_connect.php');
require("../mailer.php");

if (isset($_POST["firstname"], $_POST["lastname"],$_POST["email"],$_POST["user_name"],$_POST["pwd"]) && !empty(trim($_POST["firstname"])) && !empty(trim($_POST["lastname"])) && !empty(trim($_POST["email"])) && !empty(trim($_POST["user_name"] && !empty(trim($_POST["pwd"]))))){

} else {
    echo json_encode(["success" => false, "error" => "Donnée vide"]);
    die;
}

$regex = "/^[a-zA-Z0-9-+._]+@[a-zA-Z0-9-]{2,}\.[a-zA-Z]{2,}$/";
if(!preg_match($regex,$_POST["email"])){
    echo json_encode(["success" => false, "error"=> "email au mauvais format"]);
    die;
}

// $regex = "/^(?=.*\d)(?=.*[A-Z])(?=.*[a-z])[a-zA-Z0-9]{8,12}$/";
$regex = '/^[A-Z](?=.*\d)(?=.*[@#$%^+=!])(?=.*[a-zA-Z])[a-zA-Z0-9@#$%^+=!]{7,}$/';
if (!preg_match($regex, $_POST["pwd"])) {
    echo json_encode(["success" => false, "error" => "Mot de passe au mauvais format"]);
    die;
} else {
    $hash = password_hash($_POST["pwd"], PASSWORD_DEFAULT);
    $req = $db->prepare("INSERT INTO  users (firstname, lastname,email, user_name,pwd) VALUES (:firstname, :lastname, :email, :user_name, :pwd)");
    $req->bindValue(":firstname",$_POST["firstname"]);
    $req->bindValue("lastname",$_POST["lastname"]);
    $req->bindValue(":user_name",$_POST["user_name"]);
    $req->bindValue(":email",$_POST["email"]);
    $req->bindValue(":pwd",$hash);
    $req->execute();
    echo json_encode(["success" => true, "msg" => "inscrit"]);
    mailer("m.beaumet@gmail.com", "Bienvenu {$_POST["firstname"]} {$_POST["lastname"]}", "Merci de ton inscription");
}
