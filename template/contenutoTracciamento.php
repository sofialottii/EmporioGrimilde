<div class="row justify-content-center m-0">
    <section class="temporaneo mt-5 col-10 col-md-8 col-lg-6 pb-0">
        <h2 class="py-2">TRACCIAMENTO ORDINE</h2>
        <p>Numero ordine: 00<?php echo $templateParams["ordine"][0]["IDOrdine"] ?></p>
        <ul>
            <li class="d-flex gap-3"><label for="inPreparazione" hidden></label><input type="radio" id="inPreparazione" name="stato" value="inPreparazione" <?php if($templateParams["ordine"][0]["StatoSpedizione"] == "InPreparazione"):
            echo "checked"; endif; ?> disabled> In preparazione</li>
            <li class="d-flex gap-3"><label for="spedito" hidden></label><input type="radio" id="spedito" name="stato" value="spedito" <?php if ($templateParams["ordine"][0]["StatoSpedizione"] == "InTransito"):
            echo "checked"; endif; ?> disabled> Spedito</li>
            <li class="d-flex gap-3"><label for="consegnato" hidden></label><input type="radio" id="consegnato" name="stato" value="consegnato" <?php if ($templateParams["ordine"][0]["StatoSpedizione"] == "Consegnato"):
            echo "checked"; endif; ?> disabled> Consegnato</li>
        </ul>
        <p><a href="index.php" class="link-underline link-underline-opacity-0">Torna alla home</a></p>
    </section>
</div>