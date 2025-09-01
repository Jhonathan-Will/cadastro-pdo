<?php

    class LoginService{
        private $userTable;

        public function __cunstruct() {
            $this->userTable = new UserTable();
        }

        public function login($email, $password) {
            try {
                $user = $this->userTable->getUserByEmail($email);
                if ($user && $user['password'] === $password) {
                    return $user;
                } else {
                    return false;
                }
            } catch (PDOException $e) {
                echo 'ERROR: '. $e->getMessage();

                return false;
            }
            
        }

        public function singIn($email, $password, $name) {
            try {
                $this->userTable->createuser($email, $password, $name);
            }catch (PDOException $e) {
                echo 'ERROR: '. $e->getMessage();

                return false;
            }
        }

    }

?>