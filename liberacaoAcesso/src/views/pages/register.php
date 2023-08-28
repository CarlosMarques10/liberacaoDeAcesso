<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="<?=$base;?>/assets/css/login.css">
</head>
<body>

    <section>
        <div class="containerLogin">
            <h2>Fazer cadastro</h2>
            <form method="POST" action="<?=$base;?>/registerAction">

                <?php if(!empty($flash)): ?>
                    <div class="flash"><?=$flash;?></div>
                <?php endif;?>

                <input type="text" name="name" placeholder="Nome" class="input" required><br>
                <input type="email" name="email" placeholder="E-mail" class="input" required><br>
                <input type="password" name="password" placeholder="Senha" class="input" required><br>
                <input type="submit" value="Cadastrar-se">
            </form>
            <div class="loginRegister">Já possui uma conta? <a href="<?=$base;?>/login">Fazer login</a></div>
        </div>
    </section>
    
</body>
</html>