<?php
if(isset($_REQUEST["name"]) && $_REQUEST["name"] != "" && isset($_REQUEST["surname"]) && $_REQUEST["surname"] != "" &&
    isset($_REQUEST["email"]) && $_REQUEST["email"] != "" && isset($_REQUEST["password"]) && $_REQUEST["password"] != ""){
    $name = $_REQUEST["name"];
    $surname = $_REQUEST["surname"];
    $email = $_REQUEST["email"];
    $password = md5($_REQUEST["password"]);

    $db = new mysqli("localhost", "root", "", "sistemi");
    $query = "INSERT into Clienti(name, surname, email, password) values ('$name', '$surname', '$email', '$password')";

    try{
        $db->query($query);
    } catch (Exception $e){
        echo($e);
    }
}
else{
    echo("Inserire tutti i campi");
}