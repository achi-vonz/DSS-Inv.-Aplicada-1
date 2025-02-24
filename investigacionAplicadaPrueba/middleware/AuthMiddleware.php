<?php
require_once __DIR__ . '/../vendor/autoload.php';

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class AuthMiddleware {
    private $secretKey = 'tu_clave_secreta'; // Cambia esto por una clave segura

    // Método para generar un token JWT
    public function generateToken($userId) {
        $payload = [
            'iss' => 'http://localhost', // Emisor
            'aud' => 'http://localhost', // Audiencia
            'iat' => time(),             // Tiempo de emisión
            'exp' => time() + 3600,      // Expiración (1 hora)
            'data' => ['userId' => $userId] // Datos personalizados
        ];

        return JWT::encode($payload, $this->secretKey, 'HS256');
    }

    public function validateToken($token) {
        try {
            $decoded = JWT::decode($token, new Key($this->secretKey, 'HS256'));
            return $decoded->data; // Devuelve los datos del token
        } catch (Exception $e) {
            return false; // Token inválido o expirado
        }
    }
}