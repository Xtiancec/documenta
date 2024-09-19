<?php
// Archivo: ../controlador/LoginPostulanteController.php

if (session_status() == PHP_SESSION_NONE) {
    session_start(); // Inicia la sesión si no está iniciada
}

require_once "../modelos/Applicant.php";

class LoginPostulanteController
{
    public function verificar()
    {
        header('Content-Type: application/json'); // Forzar respuesta JSON

        ob_start(); // Inicia el buffer de salida
        try {
            $applicant = new Applicant();

            $username = isset($_POST['username']) ? limpiarCadena($_POST['username']) : "";
            $password = isset($_POST['password']) ? limpiarCadena($_POST['password']) : "";

            // Validar que los campos no estén vacíos
            if (empty($username) || empty($password)) {
                echo json_encode(['success' => false, 'message' => 'Por favor, rellena todos los campos.']);
                return;
            }

            // Intentar autenticar el usuario
            $result = $applicant->autenticar($username, $password);

            if ($result) {
                // Inicia sesión si la autenticación fue exitosa
                $_SESSION['applicant_id'] = $result['id'];
                $_SESSION['username'] = $result['username'];
                $_SESSION['user_role'] = 'postulante'; // Establecer el rol
                $_SESSION['user_type'] = 'applicant'; // Indicar que es un postulante
                $_SESSION['names'] = $result['names']; // Almacenar el nombre completo

                // Registrar el login
                $applicant->registrarLogin($result['id']);

                $response = [
                    'success' => true,
                    'role' => 'postulante',
                    'type' => 'applicant'
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

        ob_end_clean(); // Limpia el buffer de salida

        // Enviar la respuesta en formato JSON
        echo json_encode($response);
        exit();
    }
}

// Manejador de las solicitudes AJAX
if (isset($_GET['op'])) {
    $controller = new LoginPostulanteController();
    switch ($_GET['op']){
        case 'verificar':
            $controller->verificar();
            break;
    }
}

// Función para registrar errores en el archivo de log
function logError($message) {
    file_put_contents('../logs/errors.log', date('[Y-m-d H:i:s] ') . $message . PHP_EOL, FILE_APPEND);
}

// Asumiendo que limpiarCadena está definida en Conexion.php o en otro archivo incluido
?>
