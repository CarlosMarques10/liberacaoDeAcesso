<?php

namespace src\controllers;

use \core\Controller;
use DateTime;
use Exception;
use src\models\Acesso;
use src\models\Entrada;
use src\models\Saida;
use src\models\UsuarioHandler;

class HomeController extends Controller
{

    private $loggedUser;

    public function __construct()
    {
        $usuarioHandler = new UsuarioHandler();
        $this->loggedUser = $usuarioHandler->checkLogin();
        if ($this->loggedUser === false) {
            $this->redirect('/login');
        }
    }



    public function index()
    {

        $entrada = new Entrada();
        $saida = new Saida();

        $entradas = $entrada->getEntradas($this->loggedUser->getId());
        $saidas = $saida->getSaidas($this->loggedUser->getId());

        $diferencasFormatadas = [];

        



        if ($entradas != null && $saidas != null) {
            foreach ($entradas as $entrada) {
                foreach ($saidas as $saida) {
                    $dataEntrada = $entrada->getProhibited();
                    $dataSaida = $saida->getExit();

                    if ($dataEntrada !== null && $dataSaida !== null) {
                        $diferenca = strtotime($dataSaida) - strtotime($dataEntrada);

                        if ($diferenca > 0) {
                            $horas = floor($diferenca / 3600);
                            $minutos = floor(($diferenca % 3600) / 60);

                            $diferencaFormatada = sprintf("%02d:%02d", $horas, $minutos,);
                            $diferencasFormatadas[] = $diferencaFormatada;
                        }
                    }
                }
            }
        }


        $infos[] = [
            'diferencasFormatadas' => $diferencasFormatadas,
            'entradas' => $entradas,
            'saidas' => $saidas
        ];


        $this->render('home', [
            'loggedUser' => $this->loggedUser,
            'infos' => $infos
        ]);
    }


    public function addAccessProhibited()
    {

        $flash = '';
        if (!empty($_SESSION['flash'])) {
            $flash = $_SESSION['flash'];
            $_SESSION['flash'] = '';
        }

        $this->render('addAccess', [
            'flash' => $flash
        ]);
    }


    public function addAccessProhibitedAction()
    {
        $prohibited = filter_input(INPUT_POST, 'prohibited', FILTER_DEFAULT);

        if ($prohibited) {

            try {

                $formatoEntrada = 'd-m-Y H:i';
                $dateTime = DateTime::createFromFormat($formatoEntrada, $prohibited);

                if ($dateTime === false) {
                    throw new Exception('Formato de data inválida');
                }

                $dataHoraFormatada = $dateTime->format('Y-m-d H:i:s');

                $entrada = new Entrada();

                if ($entrada->verifyEntrada($this->loggedUser->getId())) {
                    $_SESSION['flash'] = 'Voce ja tem uma entrada ativa';
                    $this->redirect('/addAccessProhibited');
                } else {
                    $entrada->addEntrada($dataHoraFormatada, $this->loggedUser->getId());
                    $entrada->updateEntrada($this->loggedUser->getId());
                    $this->redirect('/');
                }
            } catch (\Exception $e) {
                $_SESSION['flash'] = $e->getMessage();
                $this->redirect('/addAccessProhibited');
            }
        }
    }


    public function addAccessExit()
    {
        $flash = '';
        if (!empty($_SESSION['flash'])) {
            $flash = $_SESSION['flash'];
            $_SESSION['flash'] = '';
        }

        $this->render('addAccessExit', [
            'flash' => $flash
        ]);
    }


    public function addAccessExitAction()
    {

        $exit = filter_input(INPUT_POST, 'exit', FILTER_DEFAULT);


        if ($exit) {
            try {
                $formatoEntrada = 'd-m-Y H:i';
                $dateTime = DateTime::createFromFormat($formatoEntrada, $exit);

                if ($dateTime === false) {
                    throw new Exception('Formato de data inválida');
                }

                $dataHoraFormatada = $dateTime->format('Y-m-d H:i');

                $saida = new Saida();
                $entrada = new Entrada();

                if ($entrada->verifyEntrada($this->loggedUser->getId())) {
                    $saida->addSaida($dataHoraFormatada, $this->loggedUser->getId());
                    $saida->updateSaida($this->loggedUser->getId());
                    $this->redirect('/');
                } else {
                    $_SESSION['flash'] = 'Voce nao possui uma entrada';
                    $this->redirect('/addAccessExit');
                }
            } catch (\Exception $e) {
                $_SESSION['flash'] = $e->getMessage();
                $this->redirect('/addAccessProhibited');
            }
        }
    }
}
