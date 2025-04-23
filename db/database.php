<?php

class DatabaseHelper{

    private $db;
    public function __construct($servername, $username, $password, $dbname, $port){
        $this->db = new mysqli($servername, $username, $password, $dbname, $port);
        if($this->db->connect_error){
            die("Connesione fallita al db");
        }
    }

    /* INDEX */
    public function getRecensioni() {
    //$n=3;
    $stmt = $this->db->prepare("
        SELECT r.NumeroStelle, r.DataRecensione, 
            r.TestoRecensione, c.Nome, c.Cognome
        FROM recensione r
        JOIN cliente c
        ON r.E_mail = c.E_mail
        ORDER BY r.DataRecensione DESC
        ");
    //LIMIT ?
    //$stmt->bind_param("i",$n);

    $stmt->execute();
    $result = $stmt->get_result();

    return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getAllRecensioni() { //QUERY ADMIN
    $stmt = $this->db->prepare("
        SELECT r.NumeroStelle, r.DataRecensione, 
            r.TestoRecensione, c.Nome, c.Cognome, c.E_mail
        FROM recensione r
        JOIN cliente c
        ON r.E_mail = c.E_mail
        ORDER BY r.DataRecensione DESC");

    $stmt->execute();
    $result = $stmt->get_result();
    return $result->fetch_all(MYSQLI_ASSOC);
    }

    /* REGISTER */
    public function registrazione($nome, $cognome, $email, $password, $dataNascita, $sesso){
        $stmt = $this->db->prepare("INSERT INTO CLIENTE (Nome, Cognome, E_mail, Password, DataNascita, Sesso)
                                            VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssss", $nome, $cognome, $email, $password, $dataNascita, $sesso);
        $stmt->execute();
    }

    public function checkEmail($email){
        $stmt = $this->db->prepare("SELECT E_mail
                                        FROM CLIENTE
                                        WHERE E_mail = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    /* LOGIN */
    public function checkLogin($email, $password){
        $stmt = $this->db->prepare("SELECT * FROM CLIENTE WHERE E_mail = ? AND Password = ?");
        $stmt->bind_param("ss", $email, $password);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function isUtenteAdmin($email){
        $stmt = $this->db->prepare("SELECT Amministratore
                                            FROM CLIENTE
                                            WHERE E_mail = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        return $row['Amministratore'] === 'Y';
    }

    /* ACQUISTO */
    public function getProdotti($cercaProdotto){
        $cercaProdotto = "%".$cercaProdotto."%";
        $stmt = $this->db->prepare("SELECT P.IDProdotto, NomeProdotto, ImmagineProdotto, Peso, PrezzoProdotto 
                                        FROM PRODOTTO P, TARIFFARIO T
                                        WHERE P.IDProdotto = T.IDProdotto
                                        AND NomeProdotto LIKE ?");
        $stmt->bind_param("s", $cercaProdotto);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    } //questa query è per gli admin perché non controlla la Visibile = Y

    public function getProdottiUtenti($cercaProdotto){
        $cercaProdotto = "%".$cercaProdotto."%";
        $stmt = $this->db->prepare("SELECT P.IDProdotto, NomeProdotto, ImmagineProdotto, Peso, PrezzoProdotto 
                                    FROM PRODOTTO P, TARIFFARIO T
                                    WHERE P.IDProdotto = T.IDProdotto
                                    AND NomeProdotto LIKE ?
                                    AND Visibile = 'Y'");
        $stmt->bind_param("s", $cercaProdotto);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function checkProdottoPreferito($IDprodotto){
        $stmt = $this->db->prepare("SELECT IDProdotto
                                        FROM preferito pref
                                        WHERE Pref.IDProdotto = ?
                                        AND pref.E_mail = ?");
        $stmt->bind_param("ss", $IDprodotto, $_SESSION["E_mail"]);          
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    /* FRUTTA PREFERITA */

    public function getProdottiPreferiti(){
        $stmt = $this->db->prepare("SELECT P.IDProdotto, NomeProdotto, ImmagineProdotto, Peso, PrezzoProdotto 
                                        FROM PRODOTTO P, TARIFFARIO T, PREFERITO pref
                                        WHERE P.IDProdotto = T.IDProdotto
                                        AND P.IDProdotto = pref.IDProdotto
                                        AND Visibile = 'Y'
                                        AND pref.E_mail = ?");
        $stmt->bind_param("s", $_SESSION["E_mail"]);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function aggiungiProdottoPreferito($IDprodotto){
        $stmt = $this->db->prepare("INSERT INTO PREFERITO (IDProdotto, E_mail)
                                        VALUES (?, ?)");
        $stmt->bind_param("ss", $IDprodotto, $_SESSION["E_mail"]);
        $stmt->execute();
    }
    public function rimuoviProdottoPreferito($IDprodotto){
        $stmt = $this->db->prepare("DELETE FROM PREFERITO
                                        WHERE IDProdotto = ?
                                        AND E_mail = ?");
        $stmt->bind_param("ss", $IDprodotto, $_SESSION["E_mail"]);
        $stmt->execute();
    }

    /* PRODOTTO */
    public function getProdotto($IDProdotto){
        $stmt = $this->db->prepare("SELECT P.IDProdotto, NomeProdotto, DescrizioneProdotto, ImmagineProdotto, Peso, PrezzoProdotto, QuantitaDisponibile, Visibile 
                                        FROM PRODOTTO P, TARIFFARIO T
                                        WHERE P.IDProdotto = T.IDProdotto
                                        AND P.IDProdotto = ?");
        $stmt->bind_param("s", $IDProdotto);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function aggiungiCarrello($IDProdotto, $quantita){
        $stmt = $this->db->prepare("INSERT INTO CARRELLO (E_mail, IDProdotto, QuantitaInCarrello)
                                        VALUES (?, ?, ?)");
        $stmt->bind_param("sss",$_SESSION["E_mail"], $IDProdotto, $quantita);
        $stmt->execute();
    }

    public function checkProdottoInCarrello($IDProdotto){
        $stmt = $this->db->prepare("SELECT IDProdotto, QuantitaInCarrello
                                        FROM carrello
                                        WHERE IDProdotto = ?
                                        AND E_mail = ?");
        $stmt->bind_param("ss", $IDProdotto, $_SESSION["E_mail"]);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function modificaQuantitaCarrello($IDProdotto, $quantita){
        $stmt = $this->db->prepare("UPDATE CARRELLO
                                        SET QuantitaInCarrello = ?
                                        WHERE IDProdotto = ?
                                        AND E_mail = ?");
        $stmt->bind_param("sss", $quantita, $IDProdotto, $_SESSION["E_mail"]);
        $stmt->execute();
    }

    /* NUOVA RECENSIONE */

    public function creaRecensione($email, $numeroStelle, $dataRecensione, $testoRecensione){
        $stmt = $this->db->prepare("INSERT INTO RECENSIONE (E_mail, NumeroStelle, DataRecensione, TestoRecensione)
                                        VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $email, $numeroStelle, $dataRecensione, $testoRecensione);
        $stmt->execute();
    }

    public function checkRecensioneFattaOggi($email, $data){
        $stmt = $this->db->prepare("SELECT E_mail
                                        FROM RECENSIONE
                                        WHERE E_mail = ?
                                        AND DataRecensione = ?");
        $stmt->bind_param("ss", $email, $data);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    /* CARRELLO */

    public function getCarrello($email){
        $stmt = $this->db->prepare("SELECT C.IDProdotto, NomeProdotto, ImmagineProdotto, DescrizioneProdotto, Peso, PrezzoProdotto, QuantitaInCarrello
                                        FROM CARRELLO C, PRODOTTO P, TARIFFARIO T
                                        WHERE C.IDProdotto = P.IDProdotto
                                        AND P.IDProdotto = T.IDProdotto
                                        AND C.E_mail = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function svuotaCarrello($email){
        $stmt = $this->db->prepare("DELETE FROM CARRELLO
                                        WHERE E_mail = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
    }

    public function rimuoviProdottoCarrello($email, $IDProdotto){
        $stmt = $this->db->prepare("DELETE FROM CARRELLO
                                        WHERE E_mail = ?
                                        AND IDProdotto = ?");
        $stmt->bind_param("ss", $email, $IDProdotto);
        $stmt->execute();
    }

    public function aggiornaQuantitaCarrello($email, $quantita, $IDProdotto){
        $stmt = $this->db->prepare("UPDATE carrello
                                            SET QuantitaInCarrello = ?
                                            WHERE IDProdotto = ? and E_mail = ?");
        $stmt->bind_param("sss", $quantita, $IDProdotto, $email);
        $stmt->execute();
    }

    /* TRACCIAMENTO */

    public function getOrdine($email, $IDOrdine){
        $stmt = $this->db->prepare("SELECT IDOrdine, DataOra, ImportoTotale, StatoSpedizione
                                        FROM ORDINE
                                        WHERE E_mail = ?
                                        AND IDOrdine = ?");
        $stmt->bind_param("si", $email, $IDOrdine);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function cambiaStatoOrdine($email, $IDOrdine, $nuovoStato){
        $stmt = $this->db->prepare("UPDATE ORDINE
                                    SET StatoSpedizione=?
                                    WHERE E_mail = ?
                                    AND IDOrdine = ?");
        $stmt->bind_param("sss",$nuovoStato, $email, $IDOrdine);
        $stmt->execute();

    }



    /* PROFILO */
    public function getProfilo(){
        $utente = $_SESSION["E_mail"];
        $stmt = $this->db->prepare("SELECT E_mail, Nome, Cognome, DataNascita, Sesso
                                    FROM CLIENTE
                                    WHERE E_mail=?");
        $stmt->bind_param("s", $utente);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }
    
    /* CAMBIA PASSWORD */
    public function modificaPassword($nuova_pass){
        $utente = $_SESSION["E_mail"];
        $pass=$nuova_pass;
        $stmt = $this->db->prepare("UPDATE CLIENTE 
                                    SET password=?
                                    WHERE E_mail=?");
        $stmt->bind_param("ss",$nuova_pass,$utente);
        $stmt->execute();
    }

    /* CAMBIO CAMPI */
    public function modificaNome($nuovo_nome){
        $utente = $_SESSION["E_mail"];
        $stmt = $this->db->prepare("UPDATE CLIENTE 
                                    SET Nome=?
                                    WHERE E_mail=?");
        $stmt->bind_param("ss",$nuovo_nome,$utente);
        $stmt->execute();
    }

    public function modificaCognome($nuovo_cognome){
        $utente = $_SESSION["E_mail"];
        $stmt = $this->db->prepare("UPDATE CLIENTE 
                                    SET Cognome=?
                                    WHERE E_mail=?");
        $stmt->bind_param("ss",$nuovo_cognome,$utente);
        $stmt->execute();
    }

    public function modificaDataNascita($nuova_data){
        $utente = $_SESSION["E_mail"];
        $stmt = $this->db->prepare("UPDATE CLIENTE 
                                    SET DataNascita=?
                                    WHERE E_mail=?");
        $stmt->bind_param("ss",$nuova_data,$utente);
        $stmt->execute();
    }

    public function modificaSesso($nuovo_sesso){
        $utente = $_SESSION["E_mail"];
        $stmt = $this->db->prepare("UPDATE CLIENTE 
                                    SET Sesso=?
                                    WHERE E_mail=?");
        $stmt->bind_param("ss",$nuovo_sesso,$utente);
        $stmt->execute();
    }

    /* PAGAMENTO */

    public function salvaDati($numeroCarta, $CVC, $dataScadenza, $nomeIntestatarioCarta, $cognomeIntestatarioCarta){
        $utente = $_SESSION["E_mail"];
        $stmt = $this->db->prepare("INSERT INTO CARTA_REGISTRATA (NumeroCarta, CVC, DataScadenza, NomeIntestatarioCarta, CognomeIntestatarioCarta, E_mail)
                                        VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssss", $numeroCarta, $CVC, $dataScadenza, $nomeIntestatarioCarta, $cognomeIntestatarioCarta, $utente);
        $stmt->execute();                           
    }

    public function getDati(){
        $utente = $_SESSION["E_mail"];
        $stmt = $this->db->prepare("SELECT NumeroCarta, DataScadenza, NomeIntestatarioCarta, CognomeIntestatarioCarta
                                    FROM CARTA_REGISTRATA
                                    WHERE E_mail=?");
        $stmt->bind_param("s", $utente);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }
    
    public function riceviDatiDalNumeroCarta($numeroCarta){
        $stmt = $this->db->prepare("SELECT NumeroCarta, CVC, DataScadenza, NomeIntestatarioCarta, CognomeIntestatarioCarta
                                            FROM carta_registrata
                                            WHERE NumeroCarta = ?");
        $stmt->bind_param("s", $numeroCarta);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getNumeroOrdini($email){
        $stmt = $this->db->prepare("SELECT IDOrdine FROM ORDINE WHERE E_mail = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function creaOrdine($IDOrdine, $dataOggi, $importoTotale, $costo_Spedizione, $email, $statoSpedizione) {
        $stmt = $this->db->prepare("INSERT INTO ORDINE (IDOrdine, DataOra, ImportoTotale, Costo_spedizione, E_mail, StatoSpedizione)
                                    VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("issdss", $IDOrdine, $dataOggi, $importoTotale, $costo_Spedizione, $email, $statoSpedizione);
        $stmt->execute();
    }

    public function creaAssociazioneContiene($IDOrdine, $dataOggi, $IDProdotto, $quantita) {
        $utente = $_SESSION["E_mail"];
        $stmt = $this->db->prepare("INSERT INTO CONTIENE (IDOrdine, E_mail, DataOra, IDProdotto, QuantitaOrdinata)
                                    VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("issii", $IDOrdine, $utente, $dataOggi, $IDProdotto, $quantita);
        $stmt->execute();
    }

    /* STORICO NOTIFICHE */ 
    public function getNotifiche(){
        $utente = $_SESSION["E_mail"];
        $stmt = $this->db->prepare("SELECT IdNotifica, TipoNotifica, TestoNotifica, DataNotifica, StatoNotifica
                                    FROM NOTIFICA
                                    WHERE E_mail=?
                                    AND NotificaAdmin = 'N'
                                    ORDER BY IdNotifica DESC");
        $stmt->bind_param("s",$utente);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function countNotificheDaLeggere(){
        $utente = $_SESSION["E_mail"];
        $stmt = $this->db->prepare("SELECT COUNT(*) as numNotifiche
                                    FROM NOTIFICA
                                    WHERE StatoNotifica = 'daLeggere'
                                    AND NotificaAdmin = 'N'
                                    AND E_mail = ?");
        $stmt->bind_param("s", $utente);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        return $row['numNotifiche'];
    }

    public function getNotificheAdmin(){
        $utente = $_SESSION["E_mail"];
        $stmt = $this->db->prepare("SELECT IdNotifica, TipoNotifica, TestoNotifica, DataNotifica, StatoNotifica
                                    FROM NOTIFICA
                                    WHERE NotificaAdmin='Y'
                                    AND E_mail = ?
                                    ORDER BY IdNotifica DESC");
        $stmt->bind_param("s",$utente);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function countNotificheAdminDaLeggere(){
        $utente = $_SESSION["E_mail"];
        $stmt = $this->db->prepare("SELECT COUNT(*) as numNotifiche
                                    FROM NOTIFICA
                                    WHERE StatoNotifica = 'daLeggere'
                                    AND NotificaAdmin = 'Y'
                                    AND E_mail = ?");
        $stmt->bind_param("s", $utente);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        return $row['numNotifiche'];
    }

    public function creaNotifica($email, $idNotifica, $tipoNotifica, $testoNotifica, $notificaAdmin){
        $stmt = $this->db->prepare("INSERT INTO NOTIFICA (E_mail, IdNotifica, TipoNotifica, TestoNotifica, DataNotifica, NotificaAdmin)
                        VALUES (?, ?, ?, ?, ?, ?)");
        $dataNotifica = date("Y-m-d H:i:s");
        $stmt->bind_param("sissss", $email, $idNotifica, $tipoNotifica, $testoNotifica, $dataNotifica, $notificaAdmin);
        $stmt->execute();
    }

    public function getIDNotificaPiuAlta($email){
        $stmt = $this->db->prepare("SELECT MAX(IdNotifica) as maxIdNotifica
                                    FROM NOTIFICA
                                    WHERE E_mail = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        return $row['maxIdNotifica'];
    }

    public function rimuoviNotifica($id){
        $utente = $_SESSION["E_mail"];
        $stmt = $this->db->prepare("DELETE FROM notifica
                                    WHERE E_mail = ?
                                    AND IdNotifica = ?");
        $stmt->bind_param("si",$utente,$id);
        $stmt->execute();                           
    }

    public function rimuoviTutteNotifiche(){
        $utente = $_SESSION["E_mail"];
        $stmt = $this->db->prepare("DELETE FROM notifica
                                    WHERE E_mail=?");
        $stmt->bind_param("s", $utente);
        $stmt->execute();
    }
    public function getNotifica($id){
        $utente = $_SESSION["E_mail"];
        $stmt = $this->db->prepare("SELECT IdNotifica, TipoNotifica, TestoNotifica, DataNotifica
                                    FROM NOTIFICA
                                    WHERE E_mail=?
                                    AND IdNotifica=?
                                    ORDER BY IdNotifica DESC");
        $stmt->bind_param("si",$utente,$id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function cambiaStatoNotifica($id){
        $utente = $_SESSION["E_mail"];
        $stmt = $this->db->prepare("UPDATE NOTIFICA
                                    SET StatoNotifica='Letta'
                                    WHERE E_mail=? AND IdNotifica=?");
        $stmt->bind_param("si", $utente, $id);
        $stmt->execute();
    }

    /* STORICO ORDINI */
    public function getOrdini(){
        $utente = $_SESSION["E_mail"];
        $stmt = $this->db->prepare("SELECT E_mail, IDOrdine, DataOra, ImportoTotale
                                    FROM ORDINE
                                    WHERE E_mail=?
                                    ORDER BY IDOrdine DESC");
        $stmt->bind_param("s", $utente);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }
    public function getElementiOrdine($id, $mail){
        $stmt = $this->db->prepare("SELECT c.IDProdotto, p.NomeProdotto, c.QuantitaOrdinata, t.PrezzoProdotto, p.ImmagineProdotto,
                                    (c.QuantitaOrdinata * t.PrezzoProdotto) AS ImportoTotale
                                    FROM contiene c JOIN PRODOTTO p
                                    ON c.IDProdotto = p.IDProdotto JOIN TARIFFARIO t ON c.IDProdotto = t.IDProdotto
                                    WHERE c.IDOrdine = ?
                                    AND C.E_mail = ?
                                    AND EXISTS ( SELECT 1 FROM ORDINE o WHERE o.IDOrdine = c.IDOrdine AND o.E_mail = ?)");
        $stmt->bind_param("iss",$id, $mail, $mail);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getTotaleOrdine($id, $mail){
        $stmt = $this->db->prepare("SELECT ImportoTotale
                                    FROM ORDINE
                                    WHERE IDOrdine = ?
                                    AND E_mail = ?");
        $stmt->bind_param("is", $id, $mail);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    /* QUERY ESCLUSIVE PER GLI ADMIN */

    public function aggiungiProdotto($IDProdotto, $NomeProdotto, $ImmagineProdotto, $DescrizioneProdotto, $QuantitaDisponibile, $Visibile){
        $stmt = $this->db->prepare("INSERT INTO PRODOTTO (IDProdotto, NomeProdotto, ImmagineProdotto, DescrizioneProdotto, QuantitaDisponibile, Visibile)
                                    VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("isssis", $IDProdotto, $NomeProdotto, $ImmagineProdotto, $DescrizioneProdotto, $QuantitaDisponibile, $Visibile);
        $stmt->execute();
    }

    public function aggiungiProdAlTariffario($IDProdotto, $Peso, $PrezzoProdotto){
        $stmt = $this->db->prepare("INSERT INTO TARIFFARIO (IDProdotto, Peso, PrezzoProdotto)
                                    VALUES (?, ?, ?)");
        $stmt->bind_param("idd", $IDProdotto, $Peso, $PrezzoProdotto);
        $stmt->execute();
    }

    public function getMaxIdProdotto(){
        $stmt = $this->db->prepare("SELECT MAX(IDProdotto) as maxID
                                    FROM PRODOTTO");
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    public function getQuantitaProdotto($IDProdotto) {
        $stmt = $this->db->prepare("SELECT QuantitaDisponibile
                                    FROM PRODOTTO
                                    WHERE IDProdotto = ?");
        $stmt->bind_param("i", $IDProdotto);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }
    public function cambiaQuantitaProdotto($IDProdotto, $nuovaQuantita) {
        $stmt = $this->db->prepare("UPDATE PRODOTTO
                                    SET QuantitaDisponibile = ?
                                    WHERE IDProdotto = ?");
        $stmt->bind_param("ii", $nuovaQuantita, $IDProdotto);
        $stmt->execute();
    }

    public function cambiaVisibilitaProdotto($IDProdotto, $visibilita) {
        $stmt = $this->db->prepare("UPDATE PRODOTTO
                                    SET Visibile = ?
                                    WHERE IDProdotto = ?");
        $stmt->bind_param("si", $visibilita, $IDProdotto);
        $stmt->execute();
    }

    public function cambiaPrezzoProdotto($IDProdotto, $nuovoPrezzo) {
        $stmt = $this->db->prepare("UPDATE TARIFFARIO
                                    SET PrezzoProdotto = ?
                                    WHERE IDProdotto = ?");
        $stmt->bind_param("di", $nuovoPrezzo, $IDProdotto);
        $stmt->execute();
    }

    public function getOrdiniAdmin(){
        $stmt = $this->db->prepare("SELECT E_mail, IDOrdine, DataOra, ImportoTotale
                                    FROM ORDINE
                                    ORDER BY E_mail, IDOrdine DESC");
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function rimuoviRecesione($mail, $data){
        $stmt = $this->db->prepare("DELETE FROM recensione
                                    WHERE E_mail = ?
                                    AND DataRecensione = ?");
        $stmt->bind_param("ss", $mail, $data);
        $stmt->execute();                           
    }

    public function getAllMails(){
        $stmt = $this->db->prepare("SELECT E_mail, Amministratore
                                        FROM CLIENTE");
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }
/*ELIMINA */
    public function emily(){
        $utente = $_SESSION["E_mail"];
        $stmt = $this->db->prepare("SELECT Nome
                                    FROM CLIENTE
                                    WHERE E_mail = ?");
        $stmt->bind_param("s", $utente);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }
}

?>