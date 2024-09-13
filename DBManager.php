<?php
class DBManager {
    private $host = 'localhost';
    private $usuario = 'sa';
    private $clave = 'Guate2024';
    private $db = 'prueba_db';
    private $conexion = null;

    public function __construct()
    {
        $this->conectar();
    }

    private function conectar()
    {
        try {
            $dsn = "sqlsrv:Server={$this->host};Database={$this->db}";
            $this->conexion = new PDO($dsn, $this->usuario, $this->clave);
            $this->conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo ("Connection failed: " . $e->getMessage());
        }
    }

    public function getConnection()
    {
        return $this->conexion;
    }

    public function disconnect()
    {
        $this->conexion = null;
    }

    // Insert a new record into the usuarios table
    public function insertUser($nombre, $email, $imagen)
    {
        $sql = "INSERT INTO usuarios (nombre, email, imagen) VALUES (:nombre, :email, :imagen)";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bindParam(':nombre', $nombre);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':imagen', $imagen);
        return $stmt->execute();
    }

    // Update an existing record in the usuarios table
    public function updateUser($id_usuario, $nombre, $email, $imagen)
    {
        $sql = "UPDATE usuarios SET nombre = :nombre, email = :email, imagen = :imagen WHERE id_usuario = :id_usuario";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bindParam(':id_usuario', $id_usuario);
        $stmt->bindParam(':nombre', $nombre);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':imagen', $imagen);
        return $stmt->execute();
    }

    // Delete a record from the usuarios table
    public function deleteUser($id_usuario)
    {
        $sql = "DELETE FROM usuarios WHERE id_usuario = :id_usuario";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bindParam(':id_usuario', $id_usuario);
        return $stmt->execute();
    }

    // Retrieve a single record from the usuarios table
    public function getUser($id_usuario)
    {
        $this->conectar();
        $sql = "SELECT * FROM usuarios WHERE id_usuario = :id_usuario";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bindParam(':id_usuario', $id_usuario);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Retrieve all records from the usuarios table
    public function getAllUsers()
    {
        $this->conectar();
        $sql = "SELECT * FROM usuarios";
        $stmt = $this->conexion->prepare($sql);
        $stmt->execute();
        $this->disconnect();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);

    }
}