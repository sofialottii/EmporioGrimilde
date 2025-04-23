<div class="row justify-content-center m-0">
<section class="temporaneo mt-5 col-10 col-md-8 col-lg-5 pb-0">
    <h2>PROFILO</h2>
    <table class="table table-borderless text-justify-center">
    <?php foreach($templateParams["profilo"] as $info):?>
        <tr>
            <th scope="row">Nome</th>
            <td><?php echo $info["Nome"];?></td>
        </tr><tr>
            <th scope="row">Cognome </th>
            <td><?php echo $info["Cognome"];?></td>
        </tr><tr>
            <th scope="row">E-Mail </th>
            <td class="text-break"><?php echo $info["E_mail"];?></td>
        </tr><tr>
            <th scope="row">Data di Nascita </th>
            <td><?php echo $info["DataNascita"];?></td>
        </tr>
    <?php endforeach?>
    </table>
    <div class="text-center">
        <ul class="p-0">
            <li class="text-center mb-3">
                <a href="index.php" class="bottone w-75">Torna alla home</a>
            </li>
            <li class="text-center mb-3">
                <a href="modificaCampi.php"  class="bottone w-75">Modifica campi</a>
            </li>
            <li class="text-center mb-3">
                <a href="modificaPassword.php" class="bottone w-75">Modifica password</a>
            </li>
        </ul>
    </div>


    <img src="../utils/img/Grimilde-CestoMele.png" alt="" class="mx-auto rounded d-block img-fluid ">
</section>
    </div>
