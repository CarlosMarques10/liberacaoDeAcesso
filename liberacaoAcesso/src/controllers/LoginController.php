<?php

namespace src\controllers;

use \core\Controller;
use Exception;
use src\models\Usuario;
use src\models\UsuarioHandler;

class LoginController extends Controller
{


    public function login()
    {
        $flash = '';
        if (!empty($_SESSION['flash'])) {
            $flash = $_SESSION['flash'];
            $_SESSION['flash'] = '';
        }


        $this->render('login', [
            'flash' => $flash
        ]);
    }


    public function loginAction()
    {

        $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
        $password = filter_input(INPUT_POST, 'password');

        try {
            if ($email && $password) {
                $usuarioHandler = new UsuarioHandler();

                $token = $usuarioHandler->verifyLogin($email, $password);

                if ($token) {
                    $_SESSION['token'] = $token;
                    $this->redirect('/');
                } else {
                    throw new Exception('E-mail e/ou senha incorreto(s)');
                }
            }
        } catch (\Exception $e) {
            $_SESSION['flash'] = $e->getMessage();
            $this->redirect('/login');
        }
    }


    public function register()
    {
        $flash = '';
        if (!empty($_SESSION['flash'])) {
            $flash = $_SESSION['flash'];
            $_SESSION['flash'] = '';
        }

        $this->render('register', [
            'flash' => $flash
        ]);
    }


    public function registerAction()
    {
        $name = filter_input(INPUT_POST, 'name');
        $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
        $password = filter_input(INPUT_POST, 'password');

        try {
            if ($name && $email && $password) {
                $usuarioHandler = new UsuarioHandler();

                if ($usuarioHandler->emailExists($email) === false) {
                    $usuario = new Usuario();
                    $usuario->setName($name);
                    $usuario->setEmail($email);
                    $usuario->setPassword($password);

                    $token = $usuarioHandler->addUser($usuario);
                    $_SESSION['token'] = $token;
                    $this->redirect('/');
                } else {
                    throw new Exception('E-mail já cadastrado');
                }
            }
        } catch (\Exception $e) {
            $_SESSION['flash'] = $e->getMessage();
            $this->redirect('/register');
        }
    }

    public function sair(){

        $_SESSION['token'] = '';
        $this->redirect('/login');
    }
}
