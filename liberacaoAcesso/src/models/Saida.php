<?php
namespace src\models;

use core\Database;

class Saida {

    private $id;
    private $exit;
    private $userId;


    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    public function getExit()
    {
        return $this->exit;
    }

    public function setExit($exit)
    {
        $this->exit = $exit;

        return $this;
    }

    public function getUserId()
    {
        return $this->userId;
    }

    public function setUserId($userId)
    {
        $this->userId = $userId;

        return $this;
    }


    public function addSaida($data,$id)
    {
        try {
            $pdo = Database::getInstance();

            $sql = $pdo->prepare("INSERT INTO saidas (exit_acesso,user_id) VALUES (:exit,:user)");
            $sql->bindValue(':exit', $data);
            $sql->bindValue(':user', $id);
            $sql->execute();
            
            if(!$sql->rowCount()){
                return null;
            }

        } catch (\Exception $e) {
            echo $e->getMessage();
        }
    }


    public function getSaidas($id){

        try {
            $data = array();
            $pdo = Database::getInstance();

            $sql = $pdo->prepare("SELECT * FROM saidas WHERE user_id = :user_id");
            $sql->bindValue(':user_id', $id);
            $sql->execute();

            if ($sql->rowCount() > 0) {
                $data = $sql->fetchAll();
            
                $saidas = array(); 
                foreach ($data as $entradaData) {
                    $saida = new Saida();
                    $saida->setId($entradaData['id']);
                    $saida->setUserId($entradaData['user_id']);
                    $saida->setExit($entradaData['exit_acesso']);
                    $saidas[] = $saida;
                }
                return $saidas;
            }
            return $data;
        } catch (\Exception $e) {
            echo $e->getMessage();
        }

    }


    public function updateSaida($id) {
        try {
            $pdo = Database::getInstance();
    
            $sql = $pdo->prepare("UPDATE entradas SET ativa = false WHERE user_id = :user AND ativa = true");
            $sql->bindValue(':user', $id);
            $sql->execute();
    
        } catch (\Exception $e) {
            echo $e->getMessage();
        }
    }


}