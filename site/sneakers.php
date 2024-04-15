<?php

require_once("db_connect.php");
require("function.php");
is_connected();

if ($_SERVER["REQUEST_METHOD"] == "POST") $method = $_POST;
else $method = $_GET;


switch($method["opt"]){
    case 'select':

        $req = $db->query("SELECT s.* FROM sneakers s ");
        $articles = $req->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode(["success" => true, "articles" => $articles]);
        break;

    case 'select_id':
        if (isset($_SESSION["users_id"])){
        
            $req=$db->prepare("SELECT * FROM sneakers WHERE users_id=?");
            $req->execute([$_SESSION["users_id"]]);
            $sneakers=$req->fetch(PDO::FETCH_ASSOC);
            echo json_encode(["success"=>true,"sneakers"=>$sneakers]);
                
        } else{
            echo json_encode(["success"=>false,"error"=>"error données manquantes"]);
        }
    
        break;


    case 'insert':
        if (isset($_POST["size"],$_POST["color"],$_POST["brand"],$_POST["state"],$_POST["price"],$_POST["stock"]) && !empty(trim($_POST["size"])) && !empty(trim($_POST["color"])) && !empty(trim($_POST["brand"])) && !empty(trim($_POST["state"])) && !empty(trim($_POST["price"])) && !empty(trim($_POST["stock"]))){
            
            $req= $db->prepare("INSERT INTO sneakers (brand,color,price,size,states,image,stock,users_id) VALUES (:brand,:color,:price,:size,:states,:image,:stock,:users_id)");

            $req->bindValue(":brand", $_POST["brand"]);
            $req->bindValue(":color", $_POST["color"]);
            $req->bindValue(":price", $_POST["price"]);
            $req->bindValue(":size", $_POST["size"]);
            $req->bindValue(":state", $_POST["state"]);
            $req->bindValue(":image",$_POST["image"]);

		    if (isset($_FILES['image'])) {
                // Récupère les informations sur le fichier
                $file_name = $_FILES['image']['name'];
                print($file_name);
                $file_tmp = $_FILES['image']['tmp_name'];
                $file_size = $_FILES['image']['size'];
                $file_error = $_FILES['image']['error'];

                // Vérifie s'il y a une erreur lors de l'envoi du fichier
                if ($file_error === 0) {
                    // Vérifie si le fichier est une image
                    $file_ext = pathinfo($file_name, PATHINFO_EXTENSION);
                    $allowed_ext = array('jpg', 'jpeg', 'png', 'gif');
                    if (in_array($file_ext, $allowed_ext)) {
                        // Déplace le fichier téléchargé vers un dossier de stockage
                        $destination = 'asset/product_img' . $file_name;
                        if (move_uploaded_file($file_tmp, $destination)) {
                            // Affiche l'image téléchargée
                            echo "<img src='$destination'>";
                        } else {
                            echo "Erreur lors de l'enregistrement du fichier.";
                        }
                    } else {
                        echo "Le fichier doit être une image de type JPG, JPEG, PNG ou GIF.";
                    }
                } else {
                    echo "Erreur lors de l'envoi du fichier.";
                }
		    }

            $req->bindValue(":stock", $_POST["stock"]);
            $req->bindValue(":users_id",$_SESSION["users_id"]);
            //$req->bindValue(":image", $_POST["image"]);
            $req->execute();
            echo json_encode((["success"=>true]));
    
        }else {
            echo json_encode((["success"=>false, "error"=>"erreur lors de l'insertion"]));
            print_r($_POST);
            print_r($_FILES);
        }
    
        break;

    case 'update_id':
        if (isset($_POST["size"],$_POST["color"],$_POST["brand"],$_POST["states"],$_POST["price"],$_POST["image"],$_POST["stock"]) && !empty(trim($_POST["size"])) && !empty(trim($_POST["color"])) && !empty(trim($_POST["brand"])) && !empty(trim($_POST["states"])) && !empty(trim($_POST["states"])) && !empty(trim($_POST["image"])) && !empty(trim($_POST["price"])) && !empty(trim($_POST["stock"]))){
            $req= $db->prepare("UPDATE sneakers SET size=:size,color=:color,brand=:brand,states=:states,image=:image,price=:price,stock=:stock WHERE users_id = :users_id");
            $req->bindValue(":size",$_POST["size"]);
            $req->bindValue(":color",$_POST["color"]);
            $req->bindValue(":brand",$_POST["brand"]);
            $req->bindValue(":states",$_POST["states"]);
            $req->bindValue(":price" ,$_POST["price"]);
            $req->bindValue(":image",$_POST["image"]);
            $req->bindValue(":stock",$_POST["stock"]);
            $req->bindValue(":users_id",$_SESSION["users_id"]);
            $req->execute();
            echo json_encode(["success"=>true]);
        }else{
            echo json_encode((["success"=>false, "error"=>"erreur lors de la mise a jour"]));
        }
           
        break;

    case 'delete_id':
        if (isset($_SESSION["users_id"]) && !empty(trim($_SESSION["users_id"]))){
            $req=$db->prepare("DELETE FROM sneakers WHERE users_id=?");
            $req->execute([$_SESSION["users_id"]]);
            echo json_encode((["success"=>true ]));

        }else{
            echo json_encode((["success"=>false, "error"=>"erreur de suppression"]));
        }
    
        break;
    
    default:
        echo json_encode(["success" => false, "error" => "Demande inconnue"]);
        break;
}