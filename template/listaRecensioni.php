<div class="container mt-5">
    <?php if(isset($templateParams["errore"])): ?>
        <div class="alert alert-primary text-center mx-5" role="alert">
            <h2><?php echo $templateParams["errore"]; ?></h2>
        </div>
        <?php else : ?>
            <h2 class="text-center mb-4">RECENSIONI</h2>
        <?php endif; ?>
    <div class="row">
    <?php $count = 0; ?>
    <?php foreach($templateParams["recensioni"] as $recensione): ?>
    <?php $count++; ?>
    <div class="col-lg-6 col-md-12 mb-4">
        <div class="card review-card shadow-sm">
            <div class="card-header text-white redbg">    
                <p class="mb-0 h4"><?php echo $recensione["Nome"]; ?> <?php echo $recensione["Cognome"]; ?></p>
                <small><?php echo $recensione["E_mail"]; ?></small>
            </div>
            <div class="card-body">
                <p class="mb-1"><?php for ($i = 1; $i <= 5; $i++) {
                    echo ($i <= $recensione["NumeroStelle"]) ? '<span class="text-warning">★</span>' : '<span class="text-secondary">★</span>';    
                } ?>
                </p>
                <aside>
                    <p><?php echo $recensione["TestoRecensione"]; ?></p>
                </aside>
            </div>
            <div class="card-footer d-flex justify-content-between align-items-center">
                <small class="text-muted">Data: <?php echo $recensione["DataRecensione"]; ?></small>
                    <form action="#" method="POST">
                        <label for="DataRec<?php echo $count; ?>" hidden></label><input type="text" class="d-none" id="DataRec<?php echo $count; ?>" name="dataRecensione" value ="<?php echo $recensione["DataRecensione"] ?>"/>
                        <label for="MailRec<?php echo $count; ?>" hidden></label><input type="text" class="d-none" id="MailRec<?php echo $count; ?>" name="mailRecensione" value ="<?php echo $recensione["E_mail"] ?>"/>
                        <label for="rimuovi<?php echo $count; ?>" hidden></label><input type="submit" id="rimuovi<?php echo $count; ?>" name="rimuovi" value="Rimuovi"/>
                    </form>
                
            </div>
        </div>
    </div>
    <?php endforeach; ?>
        <div class="text-center mt-4">
            <a href="index.php" class="bottone">Torna alla home</a>
        </div>
    </div>
</div>