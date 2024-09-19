<?php
// Archivo: ../controlador/LoginController.php

require_once "../config/Conexion.php"; // Usar require_once para evitar inclusiones múltiples
require_once "../modelos/User.php";

class LoginController
{
    public function verificar()
    {
        header('Content-Type: application/json');

        try {
            $user = new User();

            // Obtener y limpiar entradas
            $username = isset($_POST['username']) ? limpiarCadena($_POST['username']) : "";
            $password = isset($_POST['password']) ? limpiarCadena($_POST['password']) : "";
            

            // Validar que los campos no estén vacíos
            if (empty($username) || empty($password)) {
                echo json_encode(['success' => false, 'message' => 'Por favor, rellena todos los campos.']);
                return;
            }

            $result = $user->autenticar($username, $password);

            if ($result) {
                session_start();
                session_regenerate_id(true); // Regenerar el ID de sesión para seguridad
                $_SESSION['user_id'] = $result['id']; // Guardar el ID del usuario en la sesión
                $_SESSION['username'] = $result['username'];
                $_SESSION['role'] = $result['role']; // Debería ser 'adminrh'
                $_SESSION['full_name'] = $result['names'] . ' ' . $result['surname'] . ' ' . $result['lastname'];

                // Registrar el login en la tabla user_access_logs
                $user->registrarLogin($result['id']);

                $response = [
                    'success' => true,
                    'role' => $result['role']
                ];
            } else {
                $response = ['success' => false, 'message' => 'Usuario o contraseña incorrectos.'];
            }
        } catch (Exception $e) {
            logError($e->getMessage()); // Registra el error en el archivo de log
            $response = [
                'success' => false,
                'message' => 'Error interno del servidor. Por favor, inténtalo de nuevo.'
            ];
        }

        echo json_encode($response);
        exit();
    }
}

// Manejador de las solicitudes AJAX
if (isset($_GET['op'])) {
    $controller = new LoginController();
    switch ($_GET['op']) {
        case 'verificar':
            $controller->verificar();
            break;
    }
}
?>