<div class="container mt-4">
    <?php if(isset($templateParams["errore"])): ?>
        <div class="alert alert-primary text-center mx-5" role="alert">
            <h2><?php echo $templateParams["errore"]; ?></h2>
        </div>
    <?php else: ?>
        <form action="#" method="POST" class="text-center mb-4">
            <label for="cancNot" hidden></label><input type="submit" id="cancNot" name="cancellanotifiche" value="Elimina Tutte">
        </form>

    <div class="card shadow-sm">
        <div class="card-body">
            <?php $count = 0; ?>
            <?php foreach($templateParams["notifiche"] as $notifica): ?>
                <?php $count++; ?>
                <section class="p-3 border rounded shadow-sm mb-3 bg-light">
                    <form action="notifica.php" method="GET" class="d-flex flex-column">
                        <label for="IDNotifica<?php echo $count; ?>" hidden></label><input type="number" class="d-none" id="IDNotifica<?php echo $count; ?>" name="IdNotifica" value="<?php echo $notifica["IdNotifica"]; ?>" />
                        
                        <!-- Layout Desktop -->
                        <div class="d-none d-md-flex justify-content-between align-items-center">
                            <small class="text-muted">#0<?php echo $notifica["IdNotifica"]; ?></small>
                            <small class="text-muted"><?php echo $notifica["DataNotifica"]; ?></small>
                        </div>

                        <!-- Layout Mobile -->
                        <div class="d-md-none text-center">
                            <small class="text-muted">ID: #0<?php echo $notifica["IdNotifica"]; ?></small>
                            <br>
                            <small class="text-muted">Data: <?php echo $notifica["DataNotifica"]; ?></small>
                        </div>

                        <h2 class="mt-2 fw-bold h5 text-center text-md-start"><?php echo $notifica["TipoNotifica"]; ?></h2>

                        <div class="d-flex justify-content-between align-items-center mt-2">
                            <p class="mb-0">
                                <span class="badge <?php echo ($notifica["StatoNotifica"] == "daLeggere") ? 'bg-warning text-dark' : 'bg-success'; ?>">
                                    <?php echo ($notifica["StatoNotifica"] == "daLeggere") ? "Da leggere" : "Letta"; ?>
                                </span>
                            </p>
                            
                            <label for="aprii<?php echo $count; ?>" hidden></label><button type="submit" class="btn btn-primary btn-sm" id="aprii<?php echo $count; ?>">Apri</button>
                        </div>
                    </form>

                    <form action="#" method="POST" class="mt-2">
                        <label for="idNot<?php echo $count; ?>" hidden></label><input type="number" class="d-none" id="idNot<?php echo $count; ?>" name="IdNotifica" value ="<?php echo $notifica["IdNotifica"] ?>"/>
                        <label for="rimuovi<?php echo $count; ?>" hidden></label><input type="submit" id="rimuovi<?php echo $count; ?>" name="rimuovi" class="w-100" value="Rimuovi"/>
                    </form>
                </section>
            <?php endforeach; ?>
        </div>
    </div>

    
    <?php endif; ?>

    <p class="text-center mt-4"><a href="index.php" class="bottone">Torna alla home</a></p>
</div>
