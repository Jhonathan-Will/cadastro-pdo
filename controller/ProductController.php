<?php

    require_once 'db/ProductTable.php';

    header('Content-Type: application/json');

    $procductTable = new ProductTable();

    if($_SERVER['REQUEST_METHOD'] === 'POST') {
        $data = json_decode(file_get_contents('php://input'), true);
        
        if(isset($data['name']) && isset($data['value']) && isset($data['date'])) {
            $name = $data['name'];
            $value = $data['value'];
            $date = $data['date'];
            $result = $procductTable->createProduct($name, $value, $date);

            if($result) {
                http_response_code(201);
                echo json_encode(['message' => 'Product created successfully']);
            } else {
                http_response_code(500);
                echo json_encode(['message' => 'Failed to create product']);
            }
        } else {
            http_response_code(400);
            echo json_encode(['message' => 'Invalid input']);
        }
    }

    if($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id'])) {
        $id = intval($_GET['id']);
        $product = $procductTable->getProductById($id);

        if($product) {
            http_response_code(200);
            echo json_encode($product);
        } else {
            http_response_code(404);
            echo json_encode(['message' => 'Product not found']);
        }
    }

    if($_SERVER['REQUEST_METHOD']  === 'GET' && (isset($_GET['name']) || isset($_GET['value']) || isset($_GET['date']))) {
        $filters =  [
            'name' => isset($_GET['name']) ?? null,
            'value' => isset($_GET['value']) ?? null,
            'date' => isset($_GET['date']) ?? null,
        ];

        $result= $procductTable->getFilterdProducts($filters);

        if($result) {
            http_response_code(200);
            echo json_encode($result);
        } else {
            http_response_code(404);
            echo json_encode(['message' => 'No products found']);
        }
    }

    if($_SERVER['REQUEST_METHOD'] === 'PUT') {
        $data = json_decode(file_get_contents('php://input'), true);

        if(isset($data['id']) && isset($data['name']) && isset($data['value']) && isset($data['date'])) {
            $id = $data['id'];
            $name = $data['name'];
            $value = $data['value'];
            $date = $data['date'];

            $result = $procductTable->putProductById($id, $name, $value, $date);

            if($result) {
                http_response_code(200);
                echo json_encode(['message' => 'Product updated successfully']);
            } else {
                http_response_code(500);
                echo json_encode(['message' => 'Failed to update product']);
            }   
        }
    }

    if($_SERVER['REQUEST_METHOD'] === 'DELETE' && isset($_GET['id'])) {
        $id = intval($_GET['id']);
        $result = $procductTable->deleteProductById($id);

        if($result) {
            http_response_code(200);
            echo json_encode(['message' => 'Product deleted successfully']);
        } else {
            http_response_code(500);
            echo json_encode(['message' => 'Failed to delete product']);
        }
    }

?>