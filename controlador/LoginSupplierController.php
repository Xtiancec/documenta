<?php
require_once "../modelos/Supplier.php";

class LoginController
{
    public function verificar()
    {
        header('Content-Type: application/json');

        try {
            $supplier = new Supplier();

            $ruc = isset($_POST['username']) ? limpiarCadena($_POST['username']) : "";
            $password = isset($_POST['password']) ? trim($_POST['password']) : "";

            if (empty($ruc) || empty($password)) {
                echo json_encode(['success' => false, 'message' => 'Por favor, rellena todos los campos.']);
                return;
            }

            $result = $supplier->autenticar($ruc, $password);

            if ($result) {
                session_start();
                $_SESSION['supplier_id'] = $result['id'];
                $_SESSION['RUC'] = $result['RUC'];
                $_SESSION['companyName'] = $result['companyName'];
                $_SESSION['role'] = 'supplier';

                // Registrar el login en la tabla supplier_access_log
                $supplier->registrarLogin($result['id']);

                $response = [
                    'success' => true,
                    'role' => 'supplier'
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

// Función para registrar errores en el archivo de log
function logError($message) {
    file_put_contents('../logs/errors.log', date('[Y-m-d H:i:s] ') . $message . PHP_EOL, FILE_APPEND);
}

// No es necesario redefinir limpiarCadena aquí si ya está definida en Conexion.php
?>
