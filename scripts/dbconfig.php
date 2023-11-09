<?php

class BakeryDBClient {
    
    # connection details
    private $db = 'db_ba_php_app';
    private $host = '127.0.0.1';
    private $user = 'root';
    private $pwd = '';
    protected $con;

    # initialize database connection
    public function getConnection(){
        try{
            return $this->con = new PDO('mysql:host='.$this->host.';dbname='.$this->db, $this->user, $this->pwd);
        }catch(PDOException $ex){
            print_r($ex);
        }
    }

    # destroy database connection
    public function clsConnection(){
        $this->con = null;
    }

    # login the user
    public function userLogin($user, $pwd){
        try{
            $con = $this->getConnection();
            $query = 'CALL sp_LoginUser(?,?)';
            $stmt = $con->prepare($query);
            $stmt->bindParam(1, $user);
            $stmt->bindParam(2, $pwd);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $result['aMsg'];
        }catch(PDOException $ex){
            print_r($ex);
        }
    }

    public function createUser($username, $email, $password, $role) {
        try {
            $con = $this->getConnection();
            $query = 'CALL pi_CreateUser(?, ?, ?, ?)';
            $stmt = $con->prepare($query);
            $stmt->bindParam(1, $username);
            $stmt->bindParam(2, $email);
            $stmt->bindParam(3, $password);
            $stmt->bindParam(4, $role);
            $result = $stmt->execute();
            if($result){
                return true;
            }

            return false;
        } catch (PDOException $ex) {
            print_r($ex);
        }
    }

    public function editUser($userId, $username, $email, $password, $role) {
        try {
            $con = $this->getConnection();
            $query = 'CALL pu_EditUser(?, ?, ?, ?, ?)';
            $stmt = $con->prepare($query);
            $stmt->bindParam(1, $userId);
            $stmt->bindParam(2, $username);
            $stmt->bindParam(3, $email);
            $stmt->bindParam(4, $password);
            $stmt->bindParam(5, $role);
            $result = $stmt->execute();
            if($result){
                return true;
            }

            return false;
        } catch (PDOException $ex) {
            print_r($ex);
        }
    }

    public function deleteUser($userId) {
        try {
            $con = $this->getConnection();
            $query = 'CALL pd_DeleteUser(?)';
            $stmt = $con->prepare($query);
            $stmt->bindParam(1, $userId);
            $result = $stmt->execute();
            if($result){
                return true;
            }

            return false;
        } catch (PDOException $ex) {
            print_r($ex);
        }
    }

    public function makeOrder($userId, $itemId, $qty, $status, $instructions) {
        try {
            $con = $this->getConnection();
            $query = 'CALL pi_MakeOrder(?, ?, ?, ?, ?)';
            $stmt = $con->prepare($query);
            $stmt->bindParam(1, $userId);
            $stmt->bindParam(2, $itemId);
            $stmt->bindParam(3, $qty);
            $stmt->bindParam(4, $status);
            $stmt->bindParam(5, $instructions);
            $result = $stmt->execute();
            if ($result) {
                return true;
            }
            return false;
        } catch (PDOException $ex) {
            print_r($ex);
        }
    }
    
    public function updateOrder($orderId, $userId, $itemId, $qty, $status, $instructions) {
        try {
            $con = $this->getConnection();
            $query = 'CALL pu_UpdateOrder(?, ?, ?, ?, ?, ?)';
            $stmt = $con->prepare($query);
            $stmt->bindParam(1, $orderId);
            $stmt->bindParam(2, $userId);
            $stmt->bindParam(3, $itemId);
            $stmt->bindParam(4, $qty);
            $stmt->bindParam(5, $status);
            $stmt->bindParam(6, $instructions);
            $result = $stmt->execute();
            if ($result) {
                return true;
            }
            return false;
        } catch (PDOException $ex) {
            print_r($ex);
        }
    }
    
    public function deleteOrder($orderId) {
        try {
            $con = $this->getConnection();
            $query = 'CALL pd_DeleteOrder(?)';
            $stmt = $con->prepare($query);
            $stmt->bindParam(1, $orderId);
            $result = $stmt->execute();
            if ($result) {
                return true;
            }
            return false;
        } catch (PDOException $ex) {
            print_r($ex);
        }
    }
    
    public function createDelivery($userId, $itemId, $date, $qty, $instructions) {
        try {
            $con = $this->getConnection();
            $query = 'CALL pi_CreateDelivery(?, ?, ?, ?, ?)';
            $stmt = $con->prepare($query);
            $stmt->bindParam(1, $userId);
            $stmt->bindParam(2, $itemId);
            $stmt->bindParam(3, $date);
            $stmt->bindParam(4, $qty);
            $stmt->bindParam(5, $instructions);
            $result = $stmt->execute();
            if ($result) {
                return true;
            }
            return false;
        } catch (PDOException $ex) {
            print_r($ex);
        }
    }
    
    public function updateDelivery($deliveryId, $userId, $itemId, $date, $qty, $instructions) {
        try {
            $con = $this->getConnection();
            $query = 'CALL pu_UpdateDelivery(?, ?, ?, ?, ?, ?)';
            $stmt = $con->prepare($query);
            $stmt->bindParam(1, $deliveryId);
            $stmt->bindParam(2, $userId);
            $stmt->bindParam(3, $itemId);
            $stmt->bindParam(4, $date);
            $stmt->bindParam(5, $qty);
            $stmt->bindParam(6, $instructions);
            $result = $stmt->execute();
            if ($result) {
                return true;
            }
            return false;
        } catch (PDOException $ex) {
            print_r($ex);
        }
    }
    
    public function deleteDelivery($deliveryId) {
        try {
            $con = $this->getConnection();
            $query = 'CALL pd_DeleteDelivery(?)';
            $stmt = $con->prepare($query);
            $stmt->bindParam(1, $deliveryId);
            $result = $stmt->execute();
            if ($result) {
                return true;
            }
            return false;
        } catch (PDOException $ex) {
            print_r($ex);
        }
    }
    
    public function createItem($itemName, $itemPrice, $available, $discount) {
        try {
            $con = $this->getConnection();
            $query = 'CALL pi_CreateItem(?, ?, ?, ?)';
            $stmt = $con->prepare($query);
            $stmt->bindParam(1, $itemName);
            $stmt->bindParam(2, $itemPrice);
            $stmt->bindParam(3, $available);
            $stmt->bindParam(4, $discount);
            $result = $stmt->execute();
            if ($result) {
                return true;
            }
            return false;
        } catch (PDOException $ex) {
            print_r($ex);
        }
    }
    
    public function updateItem($itemId, $itemName, $itemPrice, $available, $discount) {
        try {
            $con = $this->getConnection();
            $query = 'CALL pu_UpdateItem(?, ?, ?, ?, ?)';
            $stmt = $con->prepare($query);
            $stmt->bindParam(1, $itemId);
            $stmt->bindParam(2, $itemName);
            $stmt->bindParam(3, $itemPrice);
            $stmt->bindParam(4, $available);
            $stmt->bindParam(5, $discount);
            $result = $stmt->execute();
            if ($result) {
                return true;
            }
            return false;
        } catch (PDOException $ex) {
            print_r($ex);
        }
    }
    
    public function deleteItem($itemId) {
        try {
            $con = $this->getConnection();
            $query = 'CALL pd_DeleteItem(?)';
            $stmt = $con->prepare($query);
            $stmt->bindParam(1, $itemId);
            $result = $stmt->execute();
            if ($result) {
                return true;
            }
            return false;
        } catch (PDOException $ex) {
            print_r($ex);
        }
    }
}