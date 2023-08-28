<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liberação de acessos</title>
    <link href="<?=$base;?>/assets/css/home.css" rel="stylesheet">
</head>
<body>

    <header>
        <div id="header">
            <div id="headerLeft">Liberação de acesso</div>
            <div id="headerRight"><?=$loggedUser->getName();?><span><a href="<?=$base;?>/sair">Sair</a></span></div>
        </div>
    </header>

    <section>
        <div id="container">
        <a href="<?=$base;?>/addAccessProhibited" class="addRegister">Registrar Entrada</a>
        <a href="<?=$base;?>/addAccessExit" class="addRegister">Registrar Saída</a>

        <table id="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Data e hora de entrada</th>
                    <th>Data e hora de saida</th>
                    <th>Tempo de acesso</th>
                </tr>
            </thead>

            <tbody>
            <?php foreach ($infos as $info): ?>
                <?php foreach ($info['entradas'] as $indice => $entrada): ?>
                    <tr>
                        <td><?= $entrada->getId(); ?></td>
                        <td><?= $entrada->getProhibited(); ?></td>
                        
                        <td>
                        <?php if (isset($info['saidas'][$indice])) {
                            echo $info['saidas'][$indice]->getExit();
                        } ?>
                        </td>
                        
                        <td>
                        <?php if (isset($info['saidas'][$indice])) {
                            $dataEntrada = new DateTime($entrada->getProhibited());
                            $dataSaida = new DateTime($info['saidas'][$indice]->getExit());
                            $diferenca = $dataSaida->diff($dataEntrada);
                            echo $diferenca->format('%H:%I');
                        } ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endforeach; ?>

            </tbody>
        </table>



            
        </div>

    </section>



    
</body>
</html>