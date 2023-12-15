<?php

namespace Imdvlpr;

require_once('Constant.php');
require_once(__DIR__ . '/../vendor/autoload.php');

use PDO;
use PDOException;

class Api {

    private $connection;

    public function __construct() {
        try {
            $this->connection = new PDO("mysql:host=" . SERVER_NAME . ";dbname=" . DATABASE, USERNAME, PASSWORD);
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            $this->handleStatus(false, "Connection failed: " . $e->getMessage());
        }
    }

    private function handleStatus($status, $message = "", $data = array()) {
        $response = array();
    
        if (count($data) == 0) {
            $response = array(
                "success" => $status,
                "message" => $message
            );
        } else {
            $response = array(
                "success" => $status,
                "data" => $data
            );
        }
    
        $jsonResponse = json_encode($response);
    
        if ($jsonResponse === false) {
            http_response_code(500);
            die('JSON encoding error: ' . json_last_error_msg());
        }
    
        
        if ($status) {
            http_response_code(200);
        } else {
            http_response_code(400);
        }

        header("Content-Type: application/json");
        echo $jsonResponse;
      	exit;
    }

    public function addList($title, $desc, $date, $time, $categoryId, $isCompleted) {
        try {
            $sql = "INSERT INTO " . TODO_LIST . " (" . TITLE . ", " . DESCRIPTION . ", " . DATE . ", " . TIME . ", " . CATEGORY_ID . ", " . IS_COMPLETED . ") 
            VALUES (:title, :desc, :date, :time, :categoryId, :isCompleted)";
            
            $stmt = $this->connection->prepare($sql);
            $stmt->bindParam(':title', $title);
            $stmt->bindParam(':desc', $desc);
            $stmt->bindParam(':date', $date);
            $stmt->bindParam(':time', $time);
            $stmt->bindParam(':categoryId', $categoryId);
            $stmt->bindParam(':isCompleted', $isCompleted);
            
            if ($stmt->execute()) {
                $this->handleStatus(true, "Aktivitas berhasil disimpan");
            } else {
                $this->handleStatus(false, "Aktivitas gagal disimpan");
            }
        } catch (PDOException $e) {
            $this->handleStatus(false, "Database error: " . $e->getMessage());
        }
    }

    public function addCategory($categoryName) {
        try {
            $sql = "INSERT INTO " . CATEGORY_LIST . " (" . CATEGORY_NAME . ") VALUES (:categoryName)";

            $stmt = $this->connection->prepare($sql);
            $stmt->bindParam(':categoryName', $categoryName);

            if ($stmt->execute()) {
                $this->handleStatus(true, "Kategori berhasil dibuat");
            } else {
                $this->handleStatus(false, "Kategori gagal dibuat");
            }

        } catch (PDOException $e) {
            $this->handleStatus(false, "Database error: " . $e->getMessage());
        }
    }

    public function deleteCategory($categoryId) {
        try {
            $sql = "DELETE FROM " . CATEGORY_LIST . " WHERE " . CATEGORY_ID . " = :categoryId";
            $stmt = $this->connection->prepare($sql);

            $stmt->bindParam(':categoryId', $categoryId, PDO::PARAM_INT);
            $stmt->execute();
            $rowCount = $stmt->rowCount();
    
            if ($rowCount > 0) {
                $this->handleStatus(true, "Kategori berhasil dihapus");
            } else {
                $this->handleStatus(false, "Kategori gagal dihapus");
            }
        } catch (PDOException $e) {
            $this->handleStatus(false, "Database error: " . $e->getMessage());
        }
    }

    public function editCategory($categoryId, $categoryName) {
        try {
            $sql = "UPDATE " . CATEGORY_LIST . " SET " . CATEGORY_NAME . " = :categoryName WHERE " . CATEGORY_ID . " = :categoryId";
    
            $stmt = $this->connection->prepare($sql);
            $stmt->bindParam(':categoryName', $categoryName);
            $stmt->bindParam(':categoryId', $categoryId);
    
            if ($stmt->execute()) {
                // Check if any rows were affected
                if ($stmt->rowCount() > 0) {
                    $this->handleStatus(true, "Category successfully updated");
                } else {
                    $this->handleStatus(false, "No changes made to the category");
                }
            } else {
                $this->handleStatus(false, "Failed to update category");
            }
        } catch (PDOException $e) {
            $this->handleStatus(false, "Database error: " . $e->getMessage());
        }
    }

    public function getCategoryList() {
        try {
            $sql = "SELECT * FROM " . CATEGORY_LIST;
            $stmt = $this->connection->query($sql);
    
            if ($stmt !== false) {
                $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
                if (!empty($rows)) {
                    $this->handleStatus(true, 'Success', $rows);
                } else {
                    $this->handleStatus(false, "Data tidak ditemukan", []);
                }
            } else {
                $this->handleStatus(false, "Failed to execute the query");
            }
        } catch (PDOException $e) {
            $this->handleStatus(false, "Database error: " . $e->getMessage());
        }
    }

    public function getListData() {
        try {
            $sql = "SELECT * FROM " . TODO_LIST;
            $stmt = $this->connection->query($sql);
    
            if ($stmt !== false) {
                $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
                if (!empty($rows)) {
                    $this->handleStatus(true, 'Success', $rows);
                } else {
                    $this->handleStatus(false, "Data tidak ditemukan", []);
                }
            } else {
                $this->handleStatus(false, "Failed to execute the query");
            }
        } catch (PDOException $e) {
            $this->handleStatus(false, "Database error: " . $e->getMessage());
        }
    }

    public function getActivityListByDate($date) {
        try {
            $sql = "SELECT * FROM " . TODO_LIST . " WHERE " . DATE . " = :date";
            $stmt = $this->connection->prepare($sql);
            $stmt->bindParam(':date', $date, PDO::PARAM_STR);
            $stmt->execute();
    
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
            if (!empty($rows)) {
                $this->handleStatus(true, 'Success', $rows);
            } else {
                $this->handleStatus(false, "Data tidak ditemukan", []);
            }
        } catch (PDOException $e) {
            $this->handleStatus(false, "Database error: " . $e->getMessage());
        }
    }

    public function getActivityDetail($id) {
        try {
            $sql = "SELECT * FROM " . TODO_LIST . " WHERE " . ID . " = :id";
            $stmt = $this->connection->prepare($sql);
            $stmt->bindParam(':date', $id, PDO::PARAM_INT);
            $stmt->execute();
    
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
            if (!empty($rows)) {
                $this->handleStatus(true, 'Success', $rows);
            } else {
                $this->handleStatus(false, "Data tidak ditemukan", []);
            }
        } catch (PDOException $e) {
            $this->handleStatus(false, "Database error: " . $e->getMessage());
        }
    }

    public function updateActivity($id, $isCompleted) {
        try {
            $sql = "UPDATE " . TODO_LIST . " SET " . IS_COMPLETED . " = :isCompleted WHERE " . ID . " = :id";
            
            $stmt = $this->connection->prepare($sql);
            $stmt->bindParam(':isCompleted', $isCompleted);
            $stmt->bindParam(':id', $id);
            
            if ($stmt->execute()) {
                // Check if any rows were affected
                if ($stmt->rowCount() > 0) {
                    $this->handleStatus(true, "Category successfully updated");
                } else {
                    $this->handleStatus(false, "No changes made to the category");
                }
            } else {
                $this->handleStatus(false, "Failed to update category");
            }
        } catch (PDOException $e) {
            $this->handleStatus(false, "Database error: " . $e->getMessage());
        }
    }

    public function editActivity($id, $title, $desc, $isCompleted) {
        try {
            $sql = "UPDATE " . TODO_LIST . " SET " . IS_COMPLETED . " = :isCompleted, " . TITLE . " = :title, " . DESCRIPTION . " = :description WHERE " . ID . " = :id";
            
            $stmt = $this->connection->prepare($sql);
            $stmt->bindParam(':isCompleted', $isCompleted);
            $stmt->bindParam(':title', $title);
            $stmt->bindParam(':description', $desc);
            $stmt->bindParam(':id', $id);
            
            if ($stmt->execute()) {
                $this->handleStatus(true, "Berhasil Update Data");
            } else {
                $this->handleStatus(false, "Gagal Update Data");
            }
        } catch (PDOException $e) {
            $this->handleStatus(false, "Database error: " . $e->getMessage());
        }
    }

    public function deleteActivity($id) {
        try {
            $sql = "DELETE FROM " . TODO_LIST . " WHERE " . ID . " = :id";
            $stmt = $this->connection->prepare($sql);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            $rowCount = $stmt->rowCount();
    
            if ($rowCount > 0) {
                $this->handleStatus(true, "Berhasil hapus data aktivitas");
            } else {
                $this->handleStatus(false, "Gagal hapus data aktivitas");
            }
        } catch (PDOException $e) {
            $this->handleStatus(false, "Database error: " . $e->getMessage());
        }
    }
}
