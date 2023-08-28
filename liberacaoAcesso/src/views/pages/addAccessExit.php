<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Adicionar saida</title>
    <link href="<?= $base; ?>/assets/css/addAccess.css" rel="stylesheet">
</head>

<body>

    <div class="center-screen">
        <div id="containerAddAccess">
            <div id="h2">
                <h2>Adicionar saida</h2>
            </div>
            
            <form method="POST" action="<?= $base; ?>/addAccessExitAction">

                <?php if(!empty($flash)): ?>
                    <div class="flash"><?=$flash;?></div>
                <?php endif;?>

                <input type="text" name="exit" placeholder="Data e hora de saída, ex: 25-02-2023 17:30" required><br>
                <input type="submit" value="Enviar">
            </form>
        </div>
    </div>


</body>

</html>