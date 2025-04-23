<!-- Bottone per il menu offcanvas (visibile solo su schermi piccoli) -->
<label for="first" hidden></label>
<button class="btn btn-light d-lg-none" id="first" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasResponsive" aria-controls="offcanvasResponsive">
  <img src="../utils/img/icons/menu.png" alt="menu" />
</button>

<!-- NAVIGATION PER SCHERMI GRANDI -->
<nav class="d-none d-lg-flex justify-content-between align-items-center shadow-sm px-4 bg-light border-top border-bottom col-12">
    <div class="nav-links d-flex gap-3">
        <a href="profilo.php" class="text-dark btn btn-light">Account</a>
        <?php if(!isset($_SESSION["E_mail"]) || !$dbh->isUtenteAdmin($_SESSION["E_mail"])): ?>
            <a href="fruttaPreferita.php" class="text-dark btn btn-light">Frutta Preferita</a>
            <a href="carrello.php" class="text-dark btn btn-light">Carrello</a>
            <a href="ordini.php" class="text-dark btn btn-light">I miei ordini</a>
            <a href="acquisto.php" class="text-dark btn btn-light">Prodotti</a>
        <?php else: ?>
            <a href="acquisto.php" class="text-dark btn btn-light">Gestisci Prodotti</a>
            <a href="ordini.php" class="text-dark btn btn-light">Visualizza ordini</a>
        <?php endif; ?>
    </div>

    <div class="d-flex align-items-center gap-3">
        <a href="storicoNotifiche.php" class="text-dark btn btn-light position-relative">Notifiche 
            <?php if(isset($_SESSION["E_mail"])): ?>
                <!--class="badge bg-danger position-absolute top-0 start-100 translate-middle"-->
                <span class="badge text-bg-secondary">
                    <?php echo !$dbh->isUtenteAdmin($_SESSION["E_mail"]) ? $dbh->countNotificheDaLeggere() : $dbh->countNotificheAdminDaLeggere(); ?>
                </span>
            <?php endif; ?>
        </a>

        <form action="#" method="POST" class="m-0 p-0">
            <?php if(isset($_SESSION["E_mail"])): ?>
                <label for="logoutButton" hidden></label>
                <button type="submit" id="logoutButton" name="logout" class="btn btn-danger">Logout</button>
                
            <?php else: ?>
                <div class="dropdown">
                    <a class="btn btn-light dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <img src="../utils/img/icons/specchio.png" alt="icona accesso" />
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item noscale" href="register.php">Registrati</a></li>
                        <li><a class="dropdown-item noscale" href="login.php">Accedi</a></li>
                        <li><a class="dropdown-item noscale" href="areaRiservata.php">Area Riservata</a></li>
                    </ul>
                </div>
            <?php endif; ?>
        </form>
    </div>
</nav>


<!-- Offcanvas per schermi piccoli -->
<div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasResponsive" aria-labelledby="offcanvasResponsiveLabel">
    <div class="offcanvas-header">
        <div class="container">
            <div class="row">
                <div class="col-3">
                    <img src="<?php echo getImmagineProfilo($sessoUtente); ?>" alt="icona profilo"/> 
                </div>
                <div class="col-6">
                    <h2 class="offcanvas-title" id="offcanvasResponsiveLabel"><?php echo $utente; ?></h2>
                </div>
                <div class="col-3">
                    <label for="btnOffCanvas" hidden></label>
                    <button type="button" class="btn-close" id="btnOffCanvas" data-bs-dismiss="offcanvas" data-bs-target="#offcanvasResponsive" aria-label="Close"></button>
                </div>
            </div>
        </div>
    </div>    
    <hr class="offcanvas-header">
    <div class="offcanvas-body">
        <nav>
            <ul class="list-unstyled">
                <li><a href="profilo.php">Account</a></li>
                <?php if(!isset($_SESSION["E_mail"]) || !$dbh->isUtenteAdmin($_SESSION["E_mail"])): ?>
                    <li><a href="fruttaPreferita.php">Frutta Preferita</a></li>
                    <li><a href="carrello.php">Carrello</a></li>
                    <li><a href="ordini.php">I miei ordini</a></li>
                    <li><a href="acquisto.php">Prodotti</a></li>
                <?php else: ?>
                    <li><a href="acquisto.php">Gestisci Prodotti</a></li>
                    <li><a href="ordini.php">Visualizza ordini</a></li>
                <?php endif; ?>
                <li>
                    <a href="storicoNotifiche.php">Notifiche  
                        <?php if(isset($_SESSION["E_mail"])): ?>
                            <span class="badge text-bg-secondary">
                                <?php echo !$dbh->isUtenteAdmin($_SESSION["E_mail"]) ? $dbh->countNotificheDaLeggere() : $dbh->countNotificheAdminDaLeggere(); ?>
                            </span>
                        <?php endif; ?>
                    </a>
                </li>
            </ul>
        </nav>

        <form action="#" method="POST">
            <?php if(isset($_SESSION["E_mail"])): ?>
                <label for="logoutButton2" hidden></label>
                <input type="submit" id="logoutButton2" name="logout" value="Logout" class="btn btn-outline-danger w-100" />
            <?php else: ?>
                <ul class="list-unstyled">
                    <li>
                        <label for="regButton" hidden></label>
                        <input type="submit" id="regButton" name="registrati" value="Registrati" class="btn btn-outline-primary w-100 mb-2" />
                    </li>
                    <li>
                        <label for="loginButton" hidden></label>
                        <input type="submit" id="loginButton" name="login" value="Accedi" class="btn btn-outline-success w-100 mb-2" />
                    </li>
                    <li>
                        <label for="adminButton" hidden></label>
                        <input type="submit" id="adminButton" name="loginAdmin" value="Area Riservata" class="btn btn-outline-warning w-100" />
                    </li>
                </ul>
            <?php endif; ?>
        </form>
    </div>
</div>