<?php
namespace src\models;

use core\Database;

class Entrada {


    private $id;
    private $prohibited;
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

    public function getProhibited()
    {
        return $this->prohibited;
    }

    public function setProhibited($prohibited)
    {
        $this->prohibited = $prohibited;

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

    
    public function addEntrada($data,$id)
    {
        try {
            $pdo = Database::getInstance();

            $sql = $pdo->prepare("INSERT INTO entradas (prohibited_acesso,user_id) VALUES (:prohibited,:user)");
            $sql->bindValue(':prohibited', $data);
            $sql->bindValue(':user', $id);
            $sql->execute();
            
            if ($sql->rowCount()) {
                return $pdo->lastInsertId();
            } else {
                return false;
            }

        } catch (\Exception $e) {
            echo $e->getMessage();
        }
    }

    
    public function getEntradas($id){

        try {
            $data = array();
            $pdo = Database::getInstance();

            $sql = $pdo->prepare("SELECT * FROM entradas WHERE user_id = :user_id");
            $sql->bindValue(':user_id', $id);
            $sql->execute();

            if ($sql->rowCount() > 0) {
                $data = $sql->fetchAll();
            
                $entradas = array(); 
                foreach ($data as $entradaData) {
                    $entrada = new Entrada();
                    $entrada->setId($entradaData['id']);
                    $entrada->setUserId($entradaData['user_id']);
                    $entrada->setProhibited($entradaData['prohibited_acesso']);
                    $entradas[] = $entrada;
                }
                return $entradas;
            }
                return $data;
        } catch (\Exception $e) {
            echo $e->getMessage();
        }

    }


    public function verifyEntrada($id){

        try {
            $pdo = Database::getInstance();

            $sql = $pdo->prepare("SELECT ativa FROM entradas WHERE user_id = :user AND ativa = true");
            $sql->bindValue('user', $id);
            $sql->execute();

            if($sql->rowCount()){

                if($sql->rowCount() > 0){
                    $data = $sql->fetch();
                    return $data;
                }
                return true;
            }
        } catch (\Exception $e) {
            echo $e->getMessage();
        }
    }


    public function updateEntrada($id){

        try {
            $pdo = Database::getInstance();

            $sql = $pdo->prepare("UPDATE entradas SET ativa = :ativa WHERE user_id = :user AND ativa = false");
            $sql->bindValue(':ativa' , true);
            $sql->bindValue(':user', $id);
            $sql->execute();

        } catch (\Exception $e) {
            echo $e->getMessage();
        }
    }

}