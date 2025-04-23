<div class="row justify-content-center m-0">
<section class="temporaneo mt-5 col-10 col-md-8 col-lg-4 pb-0">
    <h2>ACCESSO</h2>
    <?php if(isset($templateParams["errorelogin"])): ?>
    <p class="text-danger"><?php echo $templateParams["errorelogin"]; ?></p>
    <?php endif; ?>
    <form action="#" method="POST">
    <ul class="p-0 form">
        <li>
            <label for="E_mail" class="form-label">E-mail</label>
            <input type="email" id="E_mail" name="E_mail" class="form-control" autocomplete="on" />
        </li>
        <li class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" id="password" name="password" class="form-control" autocomplete="off" />
        </li>
        <li class="text-center mb-3">
            <label for="accedi" class="form-label" hidden></label>
            <input type="submit" name="accedi" id="accedi" value="Accedi" class="w-75" />
        </li>
        <li class="text-center mb-3">
            <label for="iscriviti" class="form-label" hidden></label> 
            <input type="submit" id="iscriviti" name="iscriviti" value="Iscriviti" class="w-75" />
        </li>
        <li class="text-center mb-3">
            <a href="index.php" class="bottone w-75" >Continua senza accedere</a>
        </li>
    </ul>
</form>
<img src="../utils/img/Grimilde-CestoMele.png" alt="" class="mx-auto rounded d-block img-fluid ">

</section>
</div>