<?php
class UsuarioModel {
    private $conexion;

    public function __construct($conexion) {
        $this->conexion = $conexion;
    }

    public function consultar($id = null) {
        $sql = ($id === null) ? "SELECT * FROM usuarios" : "SELECT * FROM usuarios WHERE id = $id";
        $resultado = $this->conexion->query($sql);

        if ($resultado) {
            $datos = [];
            while ($fila = $resultado->fetch_assoc()) {
                $datos[] = $fila;
            }
            return $datos;
        }
        return [];
    }

    // Método para insertar un nuevo usuario
    public function insertarUsuario($nombre, $email, $password, $telefono) {
        $sql = "INSERT INTO usuarios(nombre, email, password, telefono) VALUES ('$nombre', '$email', '$password', '$telefono')";
        $resultado = $this->conexion->query($sql);

        if ($resultado) {
            return $this->conexion->insert_id; // Devuelve el ID del nuevo usuario
        }
        return false; // Error al insertar
    }

    // Método para actualizar un usuario
    public function actualizarUsuario($id, $nombre, $email, $password, $telefono) {
        $sql = "UPDATE usuarios SET nombre = '$nombre', email = '$email', password = '$password', telefono = '$telefono' WHERE id = $id";
        $resultado = $this->conexion->query($sql);

        return $resultado; // Devuelve true si la actualización fue exitosa
    }

    // Método para borrar un usuario
    public function borrarUsuario($id) {
        $sql = "DELETE FROM usuarios WHERE id = $id";
        $resultado = $this->conexion->query($sql);

        return $resultado; // Devuelve true si la eliminación fue exitosa   
    }

    // Método para registrar un nuevo usuario
    public function registrarUsuario($nombre, $email, $password, $telefono) {
        $sql = "INSERT INTO usuarios(nombre, email, password, telefono) VALUES ('$nombre', '$email', '$password', '$telefono')";
        $resultado = $this->conexion->query($sql);

        if ($resultado) {
            return $this->conexion->insert_id; // Devuelve el ID del nuevo usuario
        }
        return false; // Error al registrar
    }

    // Método para autenticar un usuario
    public function autenticarUsuario($email, $password) {
        $sql = "SELECT * FROM usuarios WHERE email = '$email' AND password = '$password'";
        $resultado = $this->conexion->query($sql);
    
        if ($resultado && $resultado->num_rows > 0) {
            return $resultado->fetch_assoc(); // Devuelve los datos del usuario
        }
        return false; // Usuario no encontrado o credenciales incorrectas
    }
}