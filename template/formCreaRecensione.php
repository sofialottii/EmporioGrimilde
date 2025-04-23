<div class="row justify-content-center m-0">
    <section class="mt-5 col-10 col-md-8 col-lg-6 temporaneo">
    <form action="#" method="POST">
        <h2 class="text-center"><span>ME LA</span> LASCI UNA RECENSIONE?</h2>
        <?php if(isset($templateParams["erroreRecensione"])): ?>
        <p><?php echo $templateParams["erroreRecensione"]; ?></p>
        <?php endif; ?>
        <ul class="form p-0">
            <li class="mb-4">
                <label for="testoRecensione" class="form-label">Testo recensione</label>
                <textarea id="testoRecensione" name="testoRecensione" class="form-control" autocomplete="off"></textarea>
            </li>
            <li class="text-center">
                <span>Seleziona stelle:</span>
                <div>
                    <input type="radio" id="star1" name="rating" value="1" hidden />
                    <label for="star1">★</label>

                    <input type="radio" id="star2" name="rating" value="2" hidden />
                    <label for="star2">★</label>

                    <input type="radio" id="star3" name="rating" value="3" hidden />
                    <label for="star3">★</label>

                    <input type="radio" id="star4" name="rating" value="4" hidden />
                    <label for="star4">★</label>

                    <input type="radio" id="star5" name="rating" value="5" hidden />
                    <label for="star5">★</label>
                </div>
                <p id="output">Voto: 0/5</p>
                <script src="../js/recensione.js"></script>

            </li>
            <li class="text-center d-block">
                <label for="creaRecensione" hidden></label>
                <input type="submit" id="creaRecensione" name="creaRecensione" value="Pubblica" />
            
                <a href="index.php" class="bottone">Indietro</a>
            </li>
            <!--<li>
                <a href="index.php">Indietro</a>
            </li>-->
        </ul>
    </form>
    </section>
</div>

