<!DOCTYPE html>
<html lang="it">
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title><?php echo $templateParams["titolo"]; ?></title>
        <link rel="stylesheet" type="text/css" href="../css/style.css?v=46857" />
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    </head>
    <body>
        <header class="d-lg-block px-lg-0 pb-lg-0">
            <!--pannello per aprire canvas-->
            
            <h1 class="py-lg-3"><a href="index.php">EMPORIO DI GRIMILDE</a></h1>
            <?php if (isset($templateParams["canvas"])):
                require($templateParams["canvas"]); endif;
            ?>
        </header>

        <main class="container-fluid pb-5 px-0">
            <?php
                require($templateParams["nome"]);
            ?>
        </main>

        <footer>
            <p>
                EmporiodiGrimilde.com<br>
                Contact us: <a href="#">EmporiodiGrimilde@gmail.com</a> - 0547 837214<br>
                Privacy Policy | Cookie Policy | Info Legali
            </p>
        </footer>

    </body>
</html>