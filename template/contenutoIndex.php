

    <!-- immagine -->
    <div class="row justify-content-center mt-md-4 mt-lg-5 m-0">
        <div class="col-md-6 col-lg-7 text-center p-0">
            <img src="../utils/img/fruttaa.jpg" class="img-fluid rounded shadow" alt="Frutta" />
        </div>
    </div>

    <!-- bottone -->
    <div class="row justify-content-center mt-3 m-0">
        <div class="col-auto">
            <form action="#" method="POST">
                <input type="submit" class="px-4" name="acquista" id="acquista"
                    value="<?php echo (!isset($_SESSION['E_mail']) || !$dbh->isUtenteAdmin($_SESSION['E_mail'])) ? 'COMPRA ORA' : 'GESTISCI PRODOTTI'; ?>" />
            </form>
        </div>
    </div>


    <div class="row justify-content-evenly mt-5 m-0">
        <article class="col-10 col-md-5 text-center temporaneo">
            <h2 class="fw-bold mt-2 mb-3">CHI SIAMO?</h2>
            <p>
            Benvenuti all'Emporio di Grimilde, il miglior servizio che vi permette di gustare dell'ottima frutta ricevendola
            direttamente a casa vostra! Il nostro emporio è unico sulla scena degli E-Commerce e rappresenta un <strong>marchio di qualit&agrave; 
            certificata</strong> grazie ai nostri prodotti biologici e coltivati in modo 100% naturale. <br>
            L'Emporio di Grimilde vi permette di gustare frutta sempre fresca grazie al suo servizio di consegna di meno di 24 ore. Com'&egrave;
            possibile che sia cos&igrave; veloce vi chiederete, la risposta &egrave; semplicissima: abbiamo<strong> pi&ugrave; di 100 fornitori</strong> 
            sparsi in tutto il paese, su cui effettuiamo un rigorosissimo controllo di qualit&agrave; (per verificare che sia all'altezza degli 
            standard di Grimilde).<br>
            Il nostro emporio vi permette di scegliere tra un'ampia gamma di frutta deliziosa e <strong>appena raccolta</strong> dal nostro fornitore pi&ugrave; 
            vicino a casa vostra, questo ci permette anche di andare a ridurre al minimo le emissioni e i danni all'ambiente!<br>
            Acquista sul nostro sitto per fare un ottima, gustosissima e super salutare merenda. <strong>Provate la  frutta di Grimilde per
            essere anche voi, i pi&ugrave; belli del reame!</strong>
            </p>
        </article>

        <article class="col-10 col-md-5 mt-3 mt-md-0 temporaneo d-flex flex-column">
            <h2 class="text-center mt-2 mb-3 fw-bold">DICONO DI NOI</h2>
            <div id="carouselExample" class="carousel slide">
                <?php if(isset($templateParams["errore"])): ?>

                        <h3 class="text-center my-5 mx-4"><?php echo $templateParams["errore"]; ?></h3>
                    
                <?php else : ?>

                    <button class="position-absolute top-50 start-0 btn translate-middle carousel-control-prev" type="button" data-bs-target="#carouselExample" data-bs-slide="prev">
                        <img src="../utils/img/icons/freccia-sinistra.png" alt="Freccia sinistra" />
                    </button>
                    <div class="carousel-inner px-4">
                        <?php $recensioniPerPagina = 3;
                            $totalRecensioni = count($templateParams["recensioni"]);
                            $chunks = array_chunk($templateParams["recensioni"], $recensioniPerPagina);

                        foreach($chunks as $index => $chunk): ?>
                            <div class="carousel-item <?php echo ($index === 0) ? 'active' : ''; ?>" data-index="<?php echo $index; ?>">
                                <?php foreach($chunk as $recensione): ?>
                                    <div class="border rounded p-3 mb-3 shadow-sm bg-light">
                                        <header class="d-flex justify-content-between">
                                            <p class="fw-bold"><?php echo $recensione["Nome"] . " " . $recensione["Cognome"]; ?></p>
                                            <p>
                                                <?php for ($i = 1; $i <= 5; $i++) {
                                                    echo ($i <= $recensione["NumeroStelle"]) ? '<span class="text-warning">★</span>' : '<span class="text-secondary">★</span>';
                                                } ?>
                                            </p>
                                        </header>
                                        <aside>
                                            <p><?php echo $recensione["TestoRecensione"]; ?></p>
                                        </aside>
                                        <footer class="text-end text-muted">
                                            <small><?php echo $recensione["DataRecensione"]; ?></small>
                                        </footer>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        <?php endforeach; ?>
                    </div>

                    <button class="position-absolute top-50 start-100 btn translate-middle carousel-control-next" type="button" data-bs-target="#carouselExample" data-bs-slide="next">
                        <img src="../utils/img/icons/freccia-destra.png" alt="Freccia destra" />
                    </button>
                <?php endif; ?>
            </div>

            <!-- Pulsante Recensioni -->
            <form action="#" method="POST" class="text-center mt-3 mt-auto">
                <input type="submit" name="<?php echo (!isset($_SESSION["E_mail"]) || !$dbh->isUtenteAdmin($_SESSION["E_mail"])) ? 'creaRecensione' : 'vediRecensioni'; ?>"
                    id="<?php echo (!isset($_SESSION["E_mail"]) || !$dbh->isUtenteAdmin($_SESSION["E_mail"])) ? 'creaRecensione' : 'vediRecensioni'; ?>"
                    value="<?php echo (!isset($_SESSION["E_mail"]) || !$dbh->isUtenteAdmin($_SESSION["E_mail"])) ? 'Lascia una recensione' : 'Vedi tutte le recensioni'; ?>" />
            </form>
        </article>
    </div>  