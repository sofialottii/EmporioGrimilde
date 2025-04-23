
<?php if (empty($templateParams["prodotti"])) : ?>
    <div class="alert alert-primary text-center align-items-center mx-5 mt-3" role="alert">
        <h2>La lista dei preferiti è vuota</h2>
    </div>
<?php else : ?>
    <h2 class="text-center mt-3 mb-4">LISTA DEI PREFERITI</h2>
<?php endif; ?>

<div class="container">
    <div class="row g-4 justify-content-center">
        <?php foreach($templateParams["prodotti"] as $prodotto): ?>
            <div class="col-12 col-md-6 col-lg-3">
                <form action="prodotto.php" method="GET">
                    <label for="btn1<?php echo $prodotto['IDProdotto']; ?>" hidden></label><input type="number" class="d-none" id="btn1<?php echo $prodotto['IDProdotto']; ?>" name="IDProdotto" value="<?php echo $prodotto['IDProdotto']; ?>" />
                    <article id="prodotto_<?php echo $prodotto['IDProdotto']; ?>" class="cliccabile click temporaneo">
                        <h2 class="d-none">Prodotto</h2>
                        <header>
                            <!--uso ajax per cambiare il cuore-->
                            <label for="cambia_cuore_<?php echo $prodotto['IDProdotto']; ?>" hidden></label><button id="cambia_cuore_<?php echo $prodotto['IDProdotto']; ?>">
                                <img src="<?php echo checkPreferito($prodotto['IDProdotto']); ?>" alt="preferiti" />        
                            </button>
                        </header>
                        <section>
                            <h3 class="d-none">Immagine prodotto</h3>
                            <img src="<?php echo $prodotto['ImmagineProdotto']; ?>" alt="<?php echo $prodotto["NomeProdotto"]; ?>" />
                        </section>
                        <footer class="text-center">
                            <p class="fs-3 fw-bold"><?php echo $prodotto["NomeProdotto"]; ?></p>
                            <p>Prezzo per 1000 gr: €<?php echo number_format($prodotto["PrezzoProdotto"],2,'.',' '); ?></p>
                        </footer>
                    </article>
                    <label for="bottoneSubmit<?php echo $prodotto['IDProdotto']; ?>" hidden></label><input type="submit" id="bottoneSubmit<?php echo $prodotto['IDProdotto']; ?>" name="bt" value="bt" hidden />
                </form>


                <script>
                    document.querySelectorAll(".cliccabile").forEach(article => {
                        article.addEventListener("click", function () {

                            this.closest("form").submit(); //cerco il form più vicino e lo invio
                        });
                    });

                    document.getElementById("cambia_cuore_<?php echo $prodotto['IDProdotto']; ?>").addEventListener("click", function() {
                        event.preventDefault();
                        event.stopPropagation(); // per evitare che l'evento venga propagato al form padre (intero articolo)
                        
                        fetch("acquisto.php?IDProdotto=<?php echo $prodotto['IDProdotto']; ?>", {
                            method: "GET"
                        })
                        .then(response => response.text())
                        .then(data => {
                            // Cambia l'immagine con quella ricevuta dalla funzione PHP
                            const img = document.querySelector("#cambia_cuore_<?php echo $prodotto['IDProdotto']; ?> img");
                            img.src = data.trim(); // Assicurati che il dato ricevuto sia il percorso dell'immagine
                            console.log(data.trim());
                        })
                        .catch(error => {
                            console.error("Errore:", error);
                        });
                    });
                </script>
                
            </div>
        <?php endforeach; ?>
    </div>
</div>
<!-- bottone carrello -->



<p class="mt-4 mb-0 text-center"><a href="index.php">Torna alla home</a></p>
<!-- bottone carrello -->
<?php if(!$dbh->isUtenteAdmin($_SESSION["E_mail"])): ?>
<form action="carrello.php" method="POST">
    <label for="vaiCarrello" hidden></label>
    
    <button type="submit" id="vaiCarrello" value="Vai al carrello">
        <img src="../utils/img/icons/carrello.png" alt="carrello" />
        <span><?php echo count($templateParams["carrello"]); ?></span>
    </button>
    
</form>
<?php endif; ?>


<script src="../js/hoverSection.js"></script>