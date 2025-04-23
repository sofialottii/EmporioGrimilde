
<p class="fs-1 text-center text-uppercase fw-bold mt-3">Totale: €<?php echo number_format($totale,2,'.',' '); ?></p>

    
<div class="row justify-content-evenly mt-3 m-0 align-items-stretch">
<aside class="col-10 col-md-5 temporaneo">
    
    <?php if(isset($templateParams["errore"])): ?>
    <p class="text-dark"><?php echo $templateParams["errore"]; ?></p>
    <?php endif; ?>
    <section>
    <h2 class="text-center">Metodo di pagamento</h2>
        <ul>
            <li class="d-flex gap-3">
                <input type="radio" id="cartaSalvata" name="metodo_pagamento" value="carta_salvata" required />
                <label for="cartaSalvata">Carta salvata</label></li>

            <li class="d-flex gap-3">
                <input type="radio" id="nuovaCarta" name="metodo_pagamento" value="carta_credito" required />
                <label for="nuovaCarta">Carta di credito</label></li>

            <li class="d-flex gap-3">
                <input type="radio" id="contanti" name="metodo_pagamento" value="contanti" disabled required />
                <label for="contanti">Contanti</label></li>
        </ul>
    
    </section>

    <!--nel caso in cui venga premuto il primo bottone-->
    <section id="sezione-pagamento" style="display: none;">
        <form action="#" method="POST">
            <h3>Nuova carta</h3>
        <ul class="p-0 form row g-3">
            <li class="col-md-6"><label for="nome" class="form-label m-0">Nome </label><input type="text" id="nome" name="nome" class="form-control" required /></li>
            <li class="col-md-6"><label for="cognome" class="form-label m-0">Cognome </label><input type="text" id="cognome" name="cognome" class="form-control" required /></li>
            <li><label for="numeroCarta" class="form-label m-0">Numero Carta </label><input type="text" id="numeroCarta" name="numeroCarta" minlength="16" maxlength="16" class="form-control" required /></li>
            <li class="col-md-8"><label for="scadenza" class="form-label m-0">Scadenza </label><input type="month" id="scadenza" name="scadenza" class="form-control" required /></li>
            <li class="col-md-4"><label for="cvv" class="form-label m-0">CVV </label><input type="text" id="cvv" name="cvv" placeholder="XXX" minlength="3" maxlength="3" class="form-control" required /></li>
            <li class="d-flex gap-1">
                <input type="checkbox" id="memorizza-carta" name="memorizza_carta" class="form-check-input" /><label for="memorizza-carta" class="form-check-label"> Memorizzare carta</label>
            </li>
            <li>  
            <label for="pagaNuova" hidden></label><input type="submit" id="pagaNuova" name="pagaConNuovaCarta" value="Paga Ora" /> </li>
        </ul>
        </form>
    </section>
    
    <!--nel caso in cui venga premuto il secondo bottone-->
    <section id="sezione-carta-salvata" style="display: none;" class="text-center">
        
    <form action="#" method="POST">
            <ul class="d-flex flex-column gap-3 p-0">
                <li class="d-block">
                    <h3><label for="cartaReg" class="g-6" >Scegli la carta</label></h3><br/>
                    <select id="cartaReg" name="cartaRegistrata" class="g-6 form-select" required>
                        <option value="" disabled selected>Seleziona una carta</option>
                        <?php foreach($templateParams["carteSalvate"] as $carta): ?>
                            <option value="<?php echo $carta["NumeroCarta"]; ?>"><?php echo $carta["NumeroCarta"]; ?></option>
                        <?php endforeach; ?>
                    </select>
                    
                    
                </li>
                <li class="d-block">
                    <label for="pagaVecchia" hidden></label>
                    <input class="g-4" type="submit" id="pagaVecchia" name="pagaConVecchiaCarta" value="Paga Ora" />
                </li>
            </ul>
        </form>
    </section>

                        </aside>
<section class="col-10 col-md-5 mt-3 mt-md-0 temporaneo h-100">
    <h2>Indirizzo di Spedizione</h2>
    Via dell'universit&agrave; 30, Cesena
    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2979.2933295880252!2d12.232745665196836!3d44.147594977165184!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x132ca4dc5ea625b1%3A0xfcb0cabca301284d!2sVia%20dell&#39;%20Universit%C3%A0%2C%2030%2C%2047522%20Cesena%20FC!5e0!3m2!1sit!2sit!4v1737821529806!5m2!1sit!2sit"
        loading="lazy" referrerpolicy="no-referrer-when-downgrade" class="w-100">
    </iframe>
       
</section>
</div>
<p class="text-uppercase text-center mt-3"><a href="carrello.php" class="bottone px-4 mx-3">Annulla il pagamento</a></p>


<script src="../js/metodoPagamento.js">
</script>