<?php

$dataHost= "localhost";
$dataID= "user";
$dataPass= "password";
$dataTypeN= "fileOrForm";
$dataCon= new mysqli($localhost, $user, $password, $fileOrForm);

if($_SERVER["REQUEST_METHOD"]== "POST"){
    $email= $_POST["email"];
    $dataTypes= $_FILES["file"];
    if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
        echo "Invalid email format!!!";
    }else{
        $fileTypes=["image/jpeg", "image/jpg", "image/png"];
        if(in_array($dataTypes["type"], $fileTypes)){
            $uploadDir= "uploads/";
            $verTypes= $uploadDir . basename($dataTypes["name"]);
            if(move_uploaded_file($dataTypes["tmp_name"], $verTypes)){
                $stmt= $dataCon->prepare("INSERT INTO upFiles (email, fPath) VALUES (?, ?)");
                $stmt->bind_param("ss", $email, $verTypes);

                if($stmt->execute()){
                    echo "File uploaded successfully!";
                }else{
                    echo "Error";
                }

                $stmt->close();
            }else{
                echo "Error";
            }
        }
    }
}
?>