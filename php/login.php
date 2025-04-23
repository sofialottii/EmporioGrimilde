<?php 
require_once("bootstrap.php");

session_start();
//tutta la gestione dei bottoni e dell'iscriviti
if(isset($_POST["accedi"])){
    $email = $_POST["E_mail"];
    $password = $_POST["password"];
    $errore = false;
    $login_result = $dbh->checkLogin($email, $password);
    //login fallito:
    if(count($login_result) == 0){
        $templateParams["errorelogin"] = "Errore! Controllare username e password";
    }
    //login riuscito:
    else{
        registerLoggedUser($login_result[0]["E_mail"]);

        header("location: index.php");
        exit;
    }

}

if(isset($_POST["iscriviti"])){
    header("location: register.php");
    exit;
}

if(isset($_POST["home"])){
    header("location: index.php");
    exit;
}

$templateParams["titolo"] = "Grimilde's - Accedi";
$templateParams["nome"] = "formLogin.php";

require("../template/base.php");

?>