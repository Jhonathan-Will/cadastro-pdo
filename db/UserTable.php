<?php


    class UserTable extends DBConnection{

        public function __construct() {
            parent::__construct();       
        }


        public function createUser($email, $password, $name) {
            try {
                
                $sql = "INSERT INTO user (email, password, name) VALUES (:email, :password, :name)";
                $stmt = $this->getConnection()->prepare($sql);
                $stmt->bindParam(':email', $email);
                $stmt->bindParam(':password', $password);
                $stmt->bindParam(':name', $name);
        
                return $stmt->execute();
            } catch (PDOException $e) {
                echo 'ERROR: ' . $e->getMessage();

                return false;        
            }
        }

        public function getUserById($id) {
            try {
                $sql = 'SELECT * FREOM user WHERE id = :id_user';
                $stmt = $this->getConnection()->prepare($sql);
                $stmt->bindParam(':id_user', $id);
                $stmt->execute();
                
                return $stmt->fetch(PDO::FETCH_ASSOC);
            }catch(PDOException $e) {
                echo 'ERROR: '. $e->getMessage();

                return false;
            }
        }

        public function getUserByEmail($email) {
            try {
                $sql = 'SELECT * FREOM user WHERE email = :email_user';
                $stmt = $this->getConnection()->prepare($sql);
                $stmt->bindParam(':email_user', $email);
                $stmt->execute();
                
                return $stmt->fetch(PDO::FETCH_ASSOC);
            }catch(PDOException $e) {
                echo 'ERROR: '. $e->getMessage();

                return false;
            }            
        }



    }
?>