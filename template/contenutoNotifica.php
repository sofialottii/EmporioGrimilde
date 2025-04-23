<div class="row justify-content-center m-0">
    <section class="temporaneo mt-5 col-10 col-md-8 col-lg-6 pb-0 shadow-sm">
        <form action="#" method="POST">
            <header class="d-flex justify-content-between">
                <p class="text-start"><?php echo $templateParams["notifica"][0]["IdNotifica"]?></p>
                <p class="text-end"><?php echo $templateParams["notifica"][0]["DataNotifica"]?></p>
            </header>
            <ul class="list-unstyled">
                <li>
                    <h2 class="text-uppercase fs-4"><?php echo $templateParams["notifica"][0]["TipoNotifica"]?></h2>
                </li>
                <li>
                    <p><?php echo $templateParams["notifica"][0]["TestoNotifica"]?></p>
                </li>
                <li>
                    <label for="idNot" hidden></label>
                    <input type="number" class="d-none" id="idNot" name="IdNotifica" value ="<?php echo $templateParams["notifica"][0]["IdNotifica"]?>"/>
                </li>
                <li class="d-flex justify-content-between align-items-center mt-3">
                    <a href="storicoNotifiche.php" class="bottone">Torna alle notifiche</a>
                    <label for="rimuovi" hidden></label><input type="submit" id="rimuovi" name="rimuovi" value="Rimuovi"/>
                </li>
                <li>
                    <a href="storicoNotifiche.php" hidden>Indietro</a>
                </li>
            </ul>
        </form>
    </section>
</div>


