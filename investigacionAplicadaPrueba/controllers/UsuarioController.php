<?php
require_once ROOT . '/models/UsuarioModel.php';
require_once ROOT . '/middleware/AuthMiddleware.php';

class UsuarioController {
    private $modelo;
    private $authMiddleware;

    public function __construct($conexion) {
        $this->modelo = new UsuarioModel($conexion);
        $this->authMiddleware = new AuthMiddleware();
    }

    // Método para autenticar un usuario y generar un token JWT
    public function login() {
        // Leer el cuerpo de la solicitud como JSON
        $dato = json_decode(file_get_contents('php://input'), true);
    
        // Verificar si los datos existen
        if (!isset($dato['email']) || !isset($dato['password'])) {
            echo json_encode(['error' => 'Datos incompletos']);
            return;
        }
    
        $email = $dato['email'];
        $password = $dato['password'];
    
        // Autenticar al usuario
        $usuario = $this->modelo->autenticarUsuario($email, $password);
        if ($usuario) {
            // Generar un token JWT
            $token = $this->authMiddleware->generateToken($usuario['id']);
            echo json_encode(['mensaje' => 'Inicio de sesión exitoso', 'token' => $token]);
        } else {
            echo json_encode(['error' => 'Credenciales incorrectas']);
        }
    }

    // Método protegido: Solo accesible con un token válido
    public function consultar($id = null) {
        // Validar el token JWT
        $headers = getallheaders();
        $token = isset($headers['Authorization']) ? str_replace('Bearer ', '', $headers['Authorization']) : null;

        if (!$token || !$this->authMiddleware->validateToken($token)) {
            echo json_encode(['error' => 'Acceso no autorizado']);
            return;
        }

        // Si el token es válido, continuar con la consulta
        $datos = $this->modelo->consultar($id);
        echo json_encode($datos);
    }

    // Método para insertar un usuario
    public function insertar() {
        $dato = json_decode(file_get_contents('php://input'), true);
        $nombre = $dato['nombre'];
        $email = $dato['email'];
        $password = $dato['password'];
        $telefono = $dato['telefono'];

        $id = $this->modelo->insertarUsuario($nombre, $email, $password, $telefono);
        if ($id) {
            $dato['id'] = $id;
            echo json_encode(['mensaje' => 'Usuario creado correctamente', 'usuario' => $dato]);
        } else {
            echo json_encode(['error' => 'Error al crear el usuario']);
        }
    }

    // Método para actualizar un usuario
    public function actualizar($id) {
        // Validar el token JWT
        $headers = getallheaders();
        $token = isset($headers['Authorization']) ? str_replace('Bearer ', '', $headers['Authorization']) : null;
    
        if (!$token || !$this->authMiddleware->validateToken($token)) {
            echo json_encode(['error' => 'Acceso no autorizado']);
            return;
        }
    
        // Si el token es válido, continuar con la actualización
        $dato = json_decode(file_get_contents('php://input'), true);
        $nombre = $dato['nombre'];
        $email = $dato['email'];
        $password = $dato['password'];
        $telefono = $dato['telefono'];
    
        $resultado = $this->modelo->actualizarUsuario($id, $nombre, $email, $password, $telefono);
        if ($resultado) {
            echo json_encode(['mensaje' => 'Usuario actualizado correctamente']);
        } else {
            echo json_encode(['error' => 'Error al actualizar el usuario']);
        }
    }

    // Método para borrar un usuario
    public function borrar($id) {
        // Validar el token JWT
        $headers = getallheaders();
        $token = isset($headers['Authorization']) ? str_replace('Bearer ', '', $headers['Authorization']) : null;
    
        if (!$token || !$this->authMiddleware->validateToken($token)) {
            echo json_encode(['error' => 'Acceso no autorizado']);
            return;
        }
    
        // Si el token es válido, continuar con la eliminación
        $resultado = $this->modelo->borrarUsuario($id);
        if ($resultado) {
            echo json_encode(['mensaje' => 'Usuario borrado correctamente']);
        } else {
            echo json_encode(['error' => 'Error al borrar el usuario']);
        }
    }

    // Método para registrar un usuario
    public function registrar() {
        $nombre = $_POST['nombre'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $telefono = $_POST['telefono'];

        $id = $this->modelo->registrarUsuario($nombre, $email, $password, $telefono);
        if ($id) {
            echo "<div class='alert alert-success'>Registro exitoso. ¡Bienvenido, $nombre!</div>";
        } else {
            echo "<div class='alert alert-danger'>Error al registrar el usuario. Inténtalo de nuevo.</div>";
        }
    }
}