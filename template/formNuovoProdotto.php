<div class="row justify-content-center m-0">
    <section class="temporaneo mt-5 col-10 col-md-8 col-lg-5 pb-0">
        <!-- PER AGGIUNGERE NUOVI PRODOTTI -->
        <h2>Aggiungi un nuovo prodotto</h2>
        <form action="aggiungiProdotto.php" method="POST" enctype="multipart/form-data">
            <ul class="p-0 form">
                <li class="mb-3">
                    <label for="immagine" class="form-label">Immagine</label><input type="file" id="immagine" name="immagine" class="form-control" required />
                </li>
                <li class="mb-3">
                    <label for="nome" class="form-label">Nome prodotto</label><input type="text" id="nome" name="nome" class="form-control" autocomplete="off" required />
                </li>
                <li class="mb-3">
                    <label for="descrizione" class="form-label">Descrizione</label><textarea id="descrizione" name="descrizione" class="form-control" autocomplete="off" required></textarea>
                </li>
                <li class="mb-3">
                    <label for="prezzo" class="form-label">Prezzo</label><input type="number" id="prezzo" name="prezzo" class="form-control" step="0.01" autocomplete="off" required />
                </li>
                <li class="mb-3">
                    <label for="quantita" class="form-label">Quantità</label><input type="number" id="quantita" name="quantita" class="form-control" autocomplete="off" required />
                </li>
                <li class="mb-3">
                    <label for="visibilita" class="form-label">Visibilità</label>
                    <select id="visibilita" name="visibilita" class="form-select" required>
                        <option value="" selected disabled hidden>Seleziona un'opzione</option>
                        <option value="Y">Visibile</option>
                        <option value="N">Non visibile</option>
                    </select>
                </li>
                <li class="justify-content-between d-flex mt-4 mb-3">
                    <a href="acquisto.php">Indietro</a>
                    <label for="aggiungi" class="form-label" hidden></label><input type="submit" name="aggiungi" id="aggiungi" value="Aggiungi" />
                </li>
            
            </ul>
        </form>

    </section>
</div>
