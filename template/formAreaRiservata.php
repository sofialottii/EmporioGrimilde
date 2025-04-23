<div class="row justify-content-center m-0">
    <section class="mt-5 col-10 col-md-8 col-lg-5 temporaneo">
        <h2>Area Riservata</h2>
        <?php if(isset($templateParams["errorelogin"])): ?>
        <p class="text-danger"><?php echo $templateParams["errorelogin"]; ?></p>
        <?php endif; ?>
        <form action="#" method="POST">
        <ul class="form p-0">
            <li>
                <label for="E_mail" class="form-label">E-mail</label><input type="email" id="E_mail" name="E_mail" class="form-control" autocomplete="on" />
            </li>
            <li class="mb-3">
                <label for="password" class="form-label">Password</label><input type="password" id="password" name="password" class="form-control" autocomplete="off" />
            </li>
            <li class="text-center">
                <label for="accedi" class="form-label" hidden></label><input type="submit" name="accedi" id="accedi" value="Accedi come admin" class="mb-4 w-75" />
            </li>
            <li class="text-center">
                <a href="index.php" class="bottone w-75">Continua senza accedere</a>
            </li>
        </ul>
        </form>
    </section>
</div>