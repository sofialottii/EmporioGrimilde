-- *********************************************
-- * Standard SQL generation                   
-- *--------------------------------------------
-- * DB-MAIN version: 11.0.2              
-- * Generator date: Sep 14 2021              
-- * Generation date: Thu Jan 16 22:15:14 2025 
-- * LUN file: C:\xampp\htdocs\Web-project\db\fruttivendoli.lun 
-- * Schema: fruttivendolilun/SQL2 
-- ********************************************* 

-- ELIMINA DATABASE

DROP DATABASE GrimildeDatabase;

-- CREA IL DATABASE

create database GrimildeDatabase;


-- SELEZIONA IL DATABASE

USE GrimildeDatabase;


-- CREAZIONE TABELLE

create table CLIENTE (
     E_mail varchar(50) not null,
     Password varchar(20) not null,
     Nome varchar(20) not null,
     Cognome varchar(20) not null,
     DataNascita date not null,
     Sesso varchar(15) not null,
     ImmagineProfilo varchar(200),
     Amministratore char not null DEFAULT 'N',
     primary key (E_mail)) ENGINE = INNODB;
     
create table PRODOTTO (
     IDProdotto numeric(5) not null,
     NomeProdotto varchar(20) not null,
     ImmagineProdotto varchar(200) not null,
     DescrizioneProdotto varchar(200) not null,
     QuantitaDisponibile numeric(4) not null DEFAULT 0,
     Visibile CHAR(1) not null DEFAULT 'Y',
     primary key (IDProdotto)) ENGINE = INNODB;
     
create table carrello (
     E_mail varchar(50) not null,
     IDProdotto numeric(5) not null,
     QuantitaInCarrello numeric(3) not null,
     primary key (IDProdotto, E_mail)) ENGINE = INNODB;

create table rifornimento (
     IDRifornimento numeric (3) not null,
     E_mail varchar(50) not null,
     IDProdotto numeric(5) not null,
     QuantitaRifornita numeric(4) not null,
     primary key (IDRifornimento)) ENGINE = INNODB;

create table CARTA_REGISTRATA (
     NumeroCarta varchar(16) not null,
     CVC varchar(3) not null,
     DataScadenza varchar(7) not null,
     NomeIntestatarioCarta varchar(20) not null,
     CognomeIntestatarioCarta varchar(20) not null,
     E_mail varchar(50) not null,
     primary key (NumeroCarta)) ENGINE = INNODB;

create table contiene (
     IDOrdine numeric(5) not null,
     E_mail varchar(50) not null,
     DataOra datetime not null,
     IDProdotto numeric(5) not null,
     QuantitaOrdinata numeric(3) not null,
     primary key (IDOrdine, E_mail, IDProdotto)) ENGINE = INNODB;

create table NOTIFICA (
     E_mail varchar(50) not null,
     IdNotifica numeric(5) not null,
     TipoNotifica varchar(25) not null,
     TestoNotifica varchar(350) not null,
     DataNotifica date not null,
     NotificaAdmin char not null DEFAULT 'N',
     StatoNotifica VARCHAR(15) not null DEFAULT "daLeggere",
     primary key (E_mail, IdNotifica)) ENGINE = INNODB;

create table ORDINE (
     IDOrdine numeric(5) not null,
     DataOra datetime not null,
     ImportoTotale float(7) not null,
     Costo_spedizione float(5),
     E_mail varchar(50) not null,
     StatoSpedizione varchar(20) not null,
     primary key (IDOrdine, E_mail)) ENGINE = INNODB;

create table preferito (
     E_mail varchar(50) not null,
     IDProdotto numeric(5) not null,
     primary key (IDProdotto, E_mail)) ENGINE = INNODB;

create table presente (
     IDProdotto numeric(5) not null,
     NomeStagione varchar(10) not null,
     primary key (IDProdotto, NomeStagione)) ENGINE = INNODB;

create table RECENSIONE (
     E_mail varchar(50) not null,
     NumeroStelle float(3) not null,
     DataRecensione date not null,
     TestoRecensione varchar(250),
     primary key (E_mail, DataRecensione)) ENGINE = INNODB;

create table SPEDIZIONE (
     StatoSpedizione varchar(20) not null,
     primary key (StatoSpedizione)) ENGINE = INNODB;

create table STAGIONE (
     NomeStagione varchar(10) not null,
     primary key (NomeStagione)) ENGINE = INNODB;

create table TARIFFARIO (
     IDProdotto numeric(5) not null,
     Peso float(5) not null,
     PrezzoProdotto float(5) not null,
     primary key (IDProdotto, Peso)) ENGINE = INNODB;



-- AGGIUNTA FOREIGN KEY

alter table carrello add constraint FKcar_PRO
     foreign key (IDProdotto)
     references PRODOTTO(IDProdotto);

alter table carrello add constraint FKcar_CLI_FK
     foreign key (E_mail)
     references CLIENTE(E_mail);

alter table CARTA_REGISTRATA add constraint FKpossiede_FK
     foreign key (E_mail)
     references CLIENTE(E_mail);

alter table contiene add constraint FKcon_PRO
     foreign key (IDProdotto)
     references PRODOTTO(IDProdotto);

alter table contiene add constraint FKcon_ORD
     foreign key (IDOrdine, E_mail)
     references ORDINE(IDOrdine, E_mail);

alter table NOTIFICA add constraint FKriceve
     foreign key (E_mail)
     references CLIENTE(E_mail);

alter table ORDINE add constraint FKeffettuazione_FK
     foreign key (E_mail)
     references CLIENTE(E_mail);

alter table ORDINE add constraint FKavente_FK
     foreign key (StatoSpedizione)
     references SPEDIZIONE(StatoSpedizione);

alter table preferito add constraint FKpre_PRO_1
     foreign key (IDProdotto)
     references PRODOTTO(IDProdotto);

alter table preferito add constraint FKpre_CLI_FK
     foreign key (E_mail)
     references CLIENTE(E_mail);

alter table rifornimento add constraint FKrif_CLI_FK
     foreign key (E_mail)
     references CLIENTE(E_mail);

alter table rifornimento add constraint FKrif_PRO_1
     foreign key (IDProdotto)
     references PRODOTTO(IDProdotto);

alter table presente add constraint FKpre_STA_FK
     foreign key (NomeStagione)
     references STAGIONE(NomeStagione);

alter table presente add constraint FKpre_PRO
     foreign key (IDProdotto)
     references PRODOTTO(IDProdotto);

alter table RECENSIONE add constraint FKlascia
     foreign key (E_mail)
     references CLIENTE(E_mail);

alter table TARIFFARIO add constraint FKappartenente
     foreign key (IDProdotto)
     references PRODOTTO(IDProdotto);


-- Index Section
-- _____________ 

create unique index ID_carrello_IND
     on carrello (IDProdotto, E_mail);

create index FKcar_CLI_IND
     on carrello (E_mail);

create unique index ID_CARTA_REGISTRATA_IND
     on CARTA_REGISTRATA (NumeroCarta);

create index FKpossiede_IND
     on CARTA_REGISTRATA (E_mail);

create unique index ID_CLIENTE_IND
     on CLIENTE (E_mail);

create unique index ID_NOTIFICA_IND
     on NOTIFICA (E_mail, IdNotifica);

create unique index ID_ORDINE_IND
     on ORDINE (IDOrdine, E_mail);

create index FKeffettuazione_IND
     on ORDINE (E_mail);

create index FKavente_IND
     on ORDINE (StatoSpedizione);

create unique index ID_preferito_IND
     on preferito (IDProdotto, E_mail);

create index FKpre_CLI_IND
     on preferito (E_mail);

create unique index ID_presente_IND
     on presente (IDProdotto, NomeStagione);

create index FKpre_STA_IND
     on presente (NomeStagione);

create unique index ID_PRODOTTO_IND
     on PRODOTTO (IDProdotto);

create unique index ID_RECENSIONE_IND
     on RECENSIONE (E_mail, DataRecensione);

create unique index ID_SPEDIZIONE_IND
     on SPEDIZIONE (StatoSpedizione);

create unique index ID_STAGIONE_IND
     on STAGIONE (NomeStagione);

create unique index ID_TARIFFARIO_IND
     on TARIFFARIO (IDProdotto, Peso);

