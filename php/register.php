<?php
require_once("bootstrap.php");

session_start();

if(isset($_POST["iscriviti"])){
    $nome = $_POST["nome"];
    $cognome = $_POST["cognome"];
    $email = $_POST["E_mail"];
    $password = $_POST["password"];
    $conferma_password = $_POST["conferma_password"];
    $dataNascita = $_POST["dataNascita"];
    $sesso = $_POST["sesso"];
    $errore = false;
    if(!checkPassword($password, $conferma_password)){
        $errore = true;
        $templateParams["erroreRegister"] = "Le password non coincidono";
    }
    if ($sesso == "Nessuno"){
        $errore = true;
        $templateParams["erroreRegister"] = "Scegliere un sesso";
    }
    if (count($dbh->checkEmail($email)) > 0){
        $errore = true;
        $templateParams["erroreRegister"] = "Email esistente, effettua il login";
    }
    if(!$errore){
        $dbh->registrazione($nome, $cognome, $email, $password, $dataNascita, $sesso);
        $dbh->creaNotifica($email, 1, "Benvenuto", "Grazie per la tua registrazione al sito www.EmporioDiGrimilde.com, $nome!💖 Speriamo
        che i nostri servizi possano essere di tuo gradimento.", "N");
        //notifiche per gli admin di iscrizione di nuova persona
        $Persone = $dbh->getAllMails();
        foreach($Persone as $Persona){
            if ($Persona["Amministratore"] == 'Y'){
               $num = $dbh->getIDNotificaPiuAlta($Persona["E_mail"]);
               $dbh->creaNotifica($Persona["E_mail"], $num+1, "Nuovo utente", "$nome $cognome ($email) si è appena registrato
               al sito. Con lui, gli utenti registrati salgono a ".count($Persone).".", "Y");
            }
        }
        registerLoggedUser($email);
        header("location: index.php");
        exit;
    }
}

$templateParams["titolo"] = "Grimilde's - Registrati";
$templateParams["nome"] = "formRegistrazione.php";


require("../template/base.php");

?>