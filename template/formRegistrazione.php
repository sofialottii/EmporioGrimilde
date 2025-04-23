<div class="row justify-content-center m-0">
<section class="mt-5 col-10 col-md-8 col-lg-5 temporaneo">
<h2>ISCRIVITI</h2>
<?php if(isset($templateParams["erroreRegister"])): ?>
<p class="text-danger"><?php echo $templateParams["erroreRegister"]; ?></p>
<?php endif; ?>
<form action="#" method="POST">
    <ul class="form p-0">
        <li>
            <label for="nome" class="form-label">Nome</label><input type="text" id="nome" name="nome" class="form-control" autocomplete="on" maxlength="20" required />
        </li>
        <li>
            <label for="cognome" class="form-label">Cognome</label><input type="text" id="cognome" name="cognome" class="form-control" autocomplete="on" maxlength="20" required />
        </li>
        <li>
            <label for="E_mail" class="form-label">E-mail</label><input type="email" id="E_mail" name="E_mail" class="form-control" autocomplete="on" required />
        </li>
        <li>
            <label for="password" class="form-label">Password</label><input type="password" id="password" name="password" class="form-control" maxlength="20" autocomplete="off" required />
        </li>
        <li>
            <label for="conferma_password" class="form-label">Conferma Password</label><input type="password" id="conferma_password" class="form-control" name="conferma_password" maxlength="20" autocomplete="off" required />
        </li>
        <li>
            <label for="dataNascita" class="form-label">Data di nascita</label><input type="date" id="dataNascita" name="dataNascita" class="form-control" autocomplete="off" required />
        </li>
        <li class="mb-3">
            <label for="sesso">Sesso</label><select name="sesso" id="sesso" autocomplete="off" class="form-select" required>
                <option value="" selected disabled hidden>Scegli sesso</option>
                <option value="Uomo">Uomo</option>
                <option value="Donna">Donna</option>
                <option value="Altro">Altro</option>
            </select>
        </li>
        <li class="text-center">
            <label for="iscriviti" class="form-label" hidden></label><input type="submit" name="iscriviti" id="iscriviti" value="Iscriviti" class="w-50" />
        </li>
        <li class="text-center">
            <a href="login.php">Hai già un account? Accedi</a>
        </li>
    </ul>
</form>
</section>
</div>