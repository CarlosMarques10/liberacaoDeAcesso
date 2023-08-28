<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Adicionar entrada</title>
    <link href="<?= $base; ?>/assets/css/addAccess.css" rel="stylesheet">
</head>

<body>

    <div class="center-screen">
        <div id="containerAddAccess">
            <div id="h2">
                <h2>Adicionar entrada</h2>
            </div>
            
            <form method="POST" action="<?= $base; ?>/addAccessProhibitedAction">

                <?php if(!empty($flash)): ?>
                    <div class="flash"><?=$flash;?></div>
                <?php endif;?>

                <input type="text" name="prohibited" placeholder="Data e hora de entrada, ex: 25-02-2023 11:30" required><br>
                <input type="submit" value="Enviar">
            </form>
        </div>
    </div>


</body>

</html>