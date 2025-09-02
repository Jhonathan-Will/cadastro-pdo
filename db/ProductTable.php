<?php

require_once 'db.php';

class ProductTable extends DBConnection {
    public function __construct() {
        parent::__construct();
    }

    public function createProduct($name, $value, $date) {
        try {
            $sql = 'INSERT INTO product (name_pro, value_pro, date_pro) VALUES (:name, :value, :date)';
            $stmt = $this->getConnection()->prepare($sql);
            $stmt->bindParam(':name', $name, PDO::PARAM_STR);
            $stmt->bindParam(':value', $value, PDO::PARAM_INT);
            $stmt->bindParam(':date', $date, PDO::PARAM_STR);

            return $stmt->execute();
        } catch (PDOException $e) {
            echo 'ERROR: ' . $e->getMessage();
            return false;        
        }
    }

    public function getAllProducts() {
        try {
            $sql = 'SELECT * FROM product';
            $stmt = $this->getConnection()->prepare($sql);
            $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }catch (PDOException $e) {
            echo 'ERROR: ' . $e->getMessage();
            return false;
        }
    }

    public function getProductById($id) {
        try {
            $sql = 'SELECT * FROM product WHERE id_prod = :id';
            $stmt = $this->getConnection()->prepare($sql);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();

            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo 'ERROR: ' . $e->getMessage();
            return false;        
        }            
    }

    public function  getFilterdProducts($filters)  {
        try {
            $sql = "SELECT * FROM product WHERE 1=1";
            $params = [];

            if (!empty($filters['name'])) {
                $sql .= " AND name_prod LIKE :name";
                $params[':name'] = "%".$filters['name']."%";
            }

            if (!empty($filters['value'])) {
                $sql .= " AND value_prod = :value";
                $params[':value'] = $filters['value'];
            }

            if (!empty($filters['date'])) {
                $sql .= " AND DATE(created_at) = :date"; 
                $params[':date'] = $filters['date'];
            }

            $stmt = $this->getConnection()->prepare($sql);

            foreach ($params as $key => $value) {
                $stmt->bindValue($key, $value);
            }

            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);

        } catch (PDOException $e) {
            echo 'ERROR: ' . $e->getMessage();
            return false;        
        } 
    }

    public function putProductById($id, $name, $value, $date) {
        try {
            $sql = 'UPDATE product SET name_pro = :name, value_pro = :value date_pro = :date WHERE id_pro = :id';
            $stmt = $this->getConnection()->prepare($sql);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->bindParam(':name', $name, PDO::PARAM_STR);
            $stmt->bindParam(':date', $date, PDO::PARAM_STR);
            $stmt->bindParam(':value', $value, PDO::PARAM_INT);

            return $stmt->execute();
        } catch (PDOException $e) {
            echo 'ERROR: ' . $e->getMessage();
            return false;        
        }             
    }

    public function deleteProductById($id) {
        try {
            $sql = 'DELETE FROM product WHERE id_pro = :id';
            $stmt = $this->getConnection()->prepare($sql);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);

            return $stmt->execute();
        } catch (PDOException $e) {
            echo 'ERROR: ' . $e->getMessage();
            return false;        
        } 
    }
}
?>
