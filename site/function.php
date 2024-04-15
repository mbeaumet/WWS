<?php
session_start();

function isAdmin(){
    if(!$_SESSION["admin"]){
        echo json_encode(["success"=>"false", "error"=>"vous n'ètes pas admin"]);
        die;
    } 
}

function is_connected(){
    if(!$_SESSION["connected"]){
        echo json_encode(["success"=>"false", "error"=>"vous n'ètes pas connecté"]);
        die;
    }
    
}

function upload($file)
{
    //? Si une image est transmise via le formulaire alors
    if (isset($file["image"]["name"])) {
        //* Récupération du nom de fichier dans la superglobale FILES
        $filename = $file["image"]["name"];

        //* Chemin du fichier
        $location = __DIR__ . "/assets/product_img/$filename";

        //* Récupération de l'extension du fichier
        $extension = pathinfo($location, PATHINFO_EXTENSION);
        $extension = strtolower($extension); //* Transformation de l'extension en minuscule

        //* Liste des extensions possibles
        $valid_extensions = ["jpg", "jpeg", "png"];

        //? Si l'extension du fichier appartient au tableau des extensions valides alors
        if (in_array($extension, $valid_extensions)) {
            //? Si le fichier est bien enregistré à l'endroit souhaité alors
            if (move_uploaded_file($file["image"]["tmp_name"], $location)) return $filename;
            else return false;
        } else return false;
    } else return false;
}
