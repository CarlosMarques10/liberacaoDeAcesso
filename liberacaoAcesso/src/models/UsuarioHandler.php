<?php
namespace src\models;

use core\Database;
use Exception;

class UsuarioHandler {


    public function verifyLogin($email, $password)
    {

        try {
            $pdo = Database::getInstance();

            if($pdo)
            {
                $data = array(); 

                $sql = $pdo->prepare("SELECT * FROM usuarios WHERE email = :email");
                $sql->bindValue(':email', $email);
                $sql->execute();

                if($sql->rowCount() > 0)
                {
                    $data = $sql->fetch();

                    if(password_verify($password, $data['password_hash']))
                    {
                        $token = md5(time().rand(0,999).time());

                        $sql = $pdo->prepare("UPDATE usuarios SET token = :token WHERE email = :email");
                        $sql->bindValue(':token', $token);
                        $sql->bindValue(':email', $email);
                        $sql->execute();

                        return $token;
                    }

                }
                return false;
            }
            else
            {
                throw new Exception('Não foi possivel estabelecer conexão com o banco de dados');
            }
            
        } catch (\Exception $e) {
            echo $e->getMessage();
        }

    }


    public function emailExists($email)
    {
        try {
            $pdo = Database::getInstance();

            if($pdo)
            {
                $sql = $pdo->prepare("SELECT * FROM usuarios WHERE email = :email");
                $sql->bindValue(':email', $email);
                $sql->execute();
                
                if($sql->rowCount() > 0)
                {
                    return true;
                }
                else
                {
                    return false;
                }

            }
            else
            {
                throw new Exception('Não foi possivel estabelecer conexão com o banco de dados');
            }
            

        } catch (\Exception $e) {
            echo $e->getMessage();
        }

    }


    public function addUser(Usuario $usuario)
    {
        try {
            $pdo = Database::getInstance();

            if($pdo)
            {
                $hash = password_hash($usuario->getPassword(), PASSWORD_DEFAULT);
                $token = md5(time().rand(0,999).time());


                $sql = $pdo->prepare("INSERT INTO usuarios(name,email,password_hash,token) VALUES (:name,:email,:password,:token)");
                $sql->bindValue(':name', $usuario->getName());
                $sql->bindValue(':email', $usuario->getEmail());
                $sql->bindValue(':password', $hash);
                $sql->bindValue(':token', $token);
                $sql->execute();

                return $token;
            }
            else
            {
                throw new Exception('Não foi possivel estabelecer conexão com o banco de dados');
            }
            
        
        } catch (\Exception $e) {
            echo  $e->getMessage();
        }

    }


    public function checkLogin()
    {
        try {
            if(!empty($_SESSION['token']))
            {
                $token = $_SESSION['token'];
                $data = array();
                
                $pdo = Database::getInstance();
                if($pdo)
                {
                    $sql = $pdo->prepare("SELECT * FROM usuarios WHERE token = :token");
                    $sql->bindValue(':token', $token);
                    $sql->execute();
                    
                    if($sql->rowCount() > 0)
                    {
                        $data = $sql->fetch();

                        $loggedUser = new Usuario();
                        $loggedUser->setId($data['id']);
                        $loggedUser->setName($data['name']);
                        $loggedUser->setEmail($data['email']);
                        return $loggedUser;
                    }
                }
                else
                {
                    throw new Exception('Não foi possivel estabelecer conexão com o banco de dados');
                }
            }
            return false;

        } catch (\Exception $e) {
            echo $e->getMessage();
        }

        
    }







}