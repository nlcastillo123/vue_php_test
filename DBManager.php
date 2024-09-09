<?php
class DBManager
{
    private $host = 'localhost';
    private $usuario = 'root';
    private $clave = 'edutek';
    private $db = 'productos';
    private $conexion;

    public function __construct()
    {
        $this->conectar();
    }

    public function conectar()
    {
        $this->conexion = new mysqli($this->host, $this->usuario, $this->clave, $this->db); //
        if (!$this->conexion) {
            die('Fallo la conexion: ' . $this->conexion->connect_error);
        }
    }

    public function desconectar()
    {
        if ($this->conexion) {
            $this->conexion->close();
        }
    }

    //INSERT
    public function insert($table, $nombre, $email, $image)
    {
        $sentencia = $this->conexion->prepare("INSERT INTO $table(nombre, email, image) VALUES(?,?,?)");
        $sentencia->bind_param('sss', $nombre, $email, $image);

        if ($sentencia->execute()) {
            return $sentencia->insert_id;
        } else {
            die("Error al insertar: $sentencia->error");
        }
    }
    //UPDATE
    public function update($id_usuario, $nombre, $email, $image)
    {
        $stmt = $this->conexion->prepare("UPDATE usuarios SET nombre = ?, email = ?, image = ? WHERE id_usuario = ?");
        $stmt->bind_param("sssi", $nombre, $email, $image, $id_usuario);

        if ($stmt->execute()) {
            return true;
        } else {
            die("Error updating record: $stmt->error");
        }
    }

    //DELETE
    public function delete($id_usuario)
    {
        $stmt = $this->conexion->prepare("DELETE FROM usuarios WHERE id_usuario = ?");
        $stmt->bind_param("i", $id_usuario);

        if ($stmt->execute()) {
            return true;
        } else {
            die("Error deleting record: $stmt->error");
        }
    }

    //SEARCH
    public function search($table, $condicion)
    {
        $result = $this->conexion->query("SELECT * FROM $table WHERE $condicion")
            or die($this->conexion->error);
        if ($result) {
            return $result->fetch_all(MYSQLI_ASSOC);
        }
        return false;
    }
}
