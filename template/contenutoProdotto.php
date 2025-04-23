<article class="container mt-4 col-10">
    <div class="row align-items-center">

        <!-- Immagine prodotto -->
        <div class="col-md-5 text-center">
            <img src="<?php echo $templateParams['articolo'][0]['ImmagineProdotto']; ?>" 
                 alt="<?php echo $templateParams['articolo'][0]['NomeProdotto']; ?>" 
                 class="img-fluid rounded shadow mb-3" />

            <!--bottone preferiti-->
            <?php if(isUserLoggedIn() && !$dbh->isUtenteAdmin($_SESSION["E_mail"])): ?>
                <label for="cambia_cuore<?php echo $templateParams["articolo"][0]['IDProdotto']; ?>" hidden></label>
                <button id="cambia_cuore<?php echo $templateParams["articolo"][0]['IDProdotto']; ?>" class="btn-pagProdotto d-block m-2 m-md-0" type="button">
                    <img src="<?php echo checkPreferito($templateParams['articolo'][0]['IDProdotto']); ?>" alt="cuore-vuoto" />        
                </button>
            <?php endif; ?>
        </div>

        <!-- Informazioni prodotto -->
        <div class="col-md-7">
            <div class="card border-0 shadow-sm p-4">
                <div class="card-body">
                    <h2 class="card-title text-dark fw-bold"> <?php echo $templateParams["articolo"][0]["NomeProdotto"]; ?></h2>
                    <p class="fs-5 text-muted">€<?php echo number_format($templateParams["articolo"][0]["PrezzoProdotto"],2,'.',' '); ?> a Kg</p>
                    <p><?php echo $templateParams["articolo"][0]["DescrizioneProdotto"]; ?></p>

                    <?php if(!$templateParams["isUtenteAdmin"]): ?>
                        <form action="#" method="POST">
                            <ul class="p-0 form">
                                <li class="mb-3">
                                    <p>Quantità in Kg:</p>
                                    <label for="quantita" class="form-label" hidden></label>
                                    <input type="number" name="quantita" id="quantita" class="form-control" min="0"
                                    max="<?php echo $templateParams["articolo"][0]["QuantitaDisponibile"]; ?>" value="0" autocomplete="off" />
                                </li>
                                <?php if($templateParams["articolo"][0]["QuantitaDisponibile"] <= 5):?>
                                <li>
                                    <p class="text-danger">
                                        <?php if($templateParams["articolo"][0]["QuantitaDisponibile"] == 0):?>Prodotto esaurito!
                                        <?php else: ?>Solo <?php echo $templateParams["articolo"][0]["QuantitaDisponibile"]; ?> rimanenti nel nostro sito!
                                        <?php endif; ?>
                                    </p>
                                </li>
                                <?php endif; ?>
                                <li class="d-block">
                                    <a href="acquisto.php" class="bottone mb-3">Torna agli acquisti</a>
                                    <?php if (isUserLoggedIn()): ?>
                                        <label for="aggiungiCarrello" hidden></label><input type="submit" value="Aggiungi" name="aggiungiCarrello" id="aggiungiCarrello"
                                        <?php if($templateParams["articolo"][0]["QuantitaDisponibile"] == 0):?>disabled class="btn btn-dark border border-black"<?php endif;?> />
                                    <?php else: ?>
                                        <label for="carrelloAccedi" hidden></label><input type="submit" value="Fai il login" name="carrelloAccedi" id="carrelloAccedi"
                                        class="bottone" />
                                    <?php endif; ?>
                                </li>
                            </ul>
                        </form>
                    

                    <!-- lato admin -->
                    <?php else: ?>
                        <form action="#" method="POST">
                            <ul class="p-0 form">
                                <li>
                                    <p>Disponibilità prodotto attuale: <?php echo $templateParams["articolo"][0]["QuantitaDisponibile"]; ?></p>
                                </li>
                                <li class="mb-2 form-floating">
                                    <input type="number" autocomplete="off" name="quantitaRifornimento" id="quantitaRifornimento" class="form-control"
                                        min="-<?php echo $templateParams["articolo"][0]["QuantitaDisponibile"]; ?>" value="1" />
                                    
                                    <label for="quantitaRifornimento">Quantità rifornimento</label>
                                </li>
                                <li class="d-block text-end mb-3">
                                    <label for="cambiaRifornimento" class="form-label" hidden></label>
                                    <input type="submit" name="cambiaRifornimento" id="cambiaRifornimento" value="RIFORNISCI"/>
                                </li>
                                <li class="mb-2 form-floating">
                                    <input type="number" autocomplete="off" id="nuovoPrezzo" name="nuovoPrezzo" class="form-control"
                                        min="0" step="0.01" placeholder="€<?php echo $templateParams["articolo"][0]["PrezzoProdotto"] ?>" />
                                    <label for="nuovoPrezzo" class="text-secondary">Nuovo prezzo:</label>
                                </li>
                                <li class="d-block text-end mb-3">
                                    <label for="cambiaPrezzo" class="form-label" hidden></label>
                                    <input type="submit" id="cambiaPrezzo" name="cambiaPrezzo" value="CAMBIA PREZZO" />
                                </li>
                                <li class="d-block text-end mb-3">
                                    <label for="cambiaVisibilita" class="form-label" hidden></label>
                                    <input type="submit" id="cambiaVisibilita" name="cambiaVisibilita" class="px-4" value="RENDI <?php if($templateParams["articolo"][0]["Visibile"] == 'Y'):?>INVISIBILE<?php else:?>VISIBILE<?php endif;?>" />
                                </li>
                                <li>
                                <a href="acquisto.php" class="bottone mb-3"> Torna ai prodotti</a>
                                </li>
                            </ul>
                        </form>
                    
                    <?php endif; ?>
                </div>
            </div>
        </div>

    </div>
</article>

<script>
    document.getElementById("cambia_cuore<?php echo $templateParams["articolo"][0]['IDProdotto']; ?>").addEventListener("click", function() {
        event.preventDefault();

        fetch("acquisto.php?IDProdotto=<?php echo $templateParams["articolo"][0]['IDProdotto']; ?>", {
            method: "GET"
        })
        .then(response => response.text())
        .then(data => {
            // cambiamo l'immagine con quella ricevuta dalla funzione PHP
            const img = document.querySelector("#cambia_cuore<?php echo $templateParams["articolo"][0]['IDProdotto']; ?> img");
            img.src = data.trim(); // controlliamo che il dato ricevuto sia il percorso dell'immagine
            console.log(data.trim());
        })
        .catch(error => {
            console.error("Errore:", error);
        });
    });

    document.addEventListener("DOMContentLoaded", function () {
    const quantitaInput = document.getElementById("quantita");
    const prezzoTotale = document.getElementById("prezzoTotale");
    const prezzoUnitario = parseFloat(prezzoTotale.dataset.prezzoUnitario);

    // aggiungiamo un listener per il cambiamento del valore della quantità
    quantitaInput.addEventListener("input", function () {
        const quantita = parseInt(this.value) || 1; // Prevenire valori non numerici
        const nuovoPrezzo = (prezzoUnitario * quantita).toFixed(2);
        prezzoTotale.textContent = `€${nuovoPrezzo}`;
    });
});

</script>