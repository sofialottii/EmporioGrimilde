<?php 
require_once("bootstrap.php");
session_start();

if(isUserLoggedIn()){
    $templateParams["profilo"] = $dbh->getProfilo();
    }
    else{
        header("location: login.php");
        exit;
    }
    if(isset($_POST["ModificaCampi"])){
        $nome=$_POST["nome"];
        $cognome=$_POST["cognome"];
        $data=$_POST["dataNascita"];
        $sesso=$_POST["sesso"];
        $lista_parametri = array($nome, $cognome, $data);
   

        $error=false;

        if($sesso=="Nessuno"){
            $error=true;
            $templateParams["erroreDati"]=  "Selezionare un sesso";
        }

        foreach($lista_parametri as $parametro){
            if($parametro == "" ){
                $error=true;
                $templateParams["erroreDati"]="Inserire tutti i parametri!";
            }
        }

        if(!$error){
            $dbh->modificaNome($nome);
            $dbh->modificaCognome($cognome);
            $dbh->modificaDataNascita($data);
            $dbh->modificaSesso($sesso);
            header("location: profilo.php");
            exit;
        }

    }
    $templateParams["titolo"] = "Grimilde's - Modifica Dati"; //title
    $templateParams["nome"] = "contenutioModificaCampi.php";

require("../template/base.php");
?>