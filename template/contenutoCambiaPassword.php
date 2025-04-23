<div class="row justify-content-center m-0">
<section class="temporaneo mt-5 col-10 col-md-8 col-lg-4 pb-0">
    <h2 class="mb-3">PROFILO</h2>
    <?php if(isset($templateParams["errorelogin"])): ?>
    <p class="text-danger"><?php echo $templateParams["errorelogin"]; ?></p>
    <?php endif; ?>
    <form action="#" method="POST">
        <ul class="p-0 form">
            <li class="mb-3">
                <label for="vecchia_password" class="form-label">Vecchia Password</label>
                <input type="password" id="vecchia_password" name="vecchia_password" autocomplete="off" class="form-control"/>
            </li>
            <li class="mb-3">
                <label for="nuova_password" class="form-label">Nuova Password</label>
                <input type="password" id="nuova_password" name="nuova_password" autocomplete="off" class="form-control"/>
            </li>
            <li class=" mb-3">
                <label for="conferma_password" class="form-label">Conferma Password</label>
                <input type="password" id="conferma_password" name="conferma_password" autocomplete="off" class="form-control"/>
            </li>
            <li  class="text-center mb-3">
                <input type="submit" name="aggiornaPassword" id="aggiornaPassword" value="Salva Password"  class="w-75"/>
            </li>
            <li  class="text-center mb-3">
                <a href="profilo.php" class="bottone w-75">Ho cambiato idea</a>
            </li>
            
            
        </ul>
    </form>
    <img src="../utils/img/Grimilde-CestoMele.png" alt="" class="mx-auto rounded d-block img-fluid ">
</section>
    </div>