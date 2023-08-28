<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="<?=$base;?>/assets/css/login.css">
</head>
<body>

    <section>
        <div class="containerLogin">
            <h2>Fazer login</h2>
            <form method="POST" action="<?=$base;?>/loginAction">

                <?php if(!empty($flash)): ?>
                    <div class="flash"><?=$flash;?></div>
                <?php endif;?>

                <input type="email" name="email" placeholder="Digite seu e-mail" class="input" required><br>
                <input type="password" name="password" placeholder="Digite sua senha" class="input" required><br>
                <input type="submit" value="Entrar">
            </form>
            <div class="loginRegister">Não tem uma conta? <a href="<?=$base;?>/register">Fazer cadastro</a></div>
        </div>
    </section>
    
</body>
</html>