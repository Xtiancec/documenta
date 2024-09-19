<?php
require "../config/Conexion.php";

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../vendor/autoload.php';

class User
{

    // Listar todos los usuarios
    public function listar()

    {
        $sql = "SELECT u.id, u.username, u.email, u.lastname, u.surname, u.names, u.nacionality, u.role, u.is_active, jp.position_name, c.company_name, c.id as company_id
        FROM users u
        LEFT JOIN companies c ON u.company_id = c.id
        LEFT JOIN job_positions jp ON u.job_id = jp.id";
        return ejecutarConsulta($sql);
    }


    // Insertar un nuevo usuario (por el administrador)
    public function insertar($company_id, $username, $email, $lastname, $surname, $names, $nacionality, $role, $job_id)
    {
        $password = bin2hex(random_bytes(4)); // Generar una contraseña aleatoria
        $password_hashed = password_hash($password, PASSWORD_DEFAULT); // Encriptar la contraseña

        $sql = "INSERT INTO users (company_id, username, password, email, lastname, surname, names, nacionality, role, is_active, job_id) 
                VALUES ('$company_id', '$username', '$password_hashed', '$email', '$lastname', '$surname', '$names', '$nacionality', '$role', '1', '$job_id')";

        $result = ejecutarConsulta($sql);

        if ($result) {
            // Enviar correo con la contraseña generada
            if (!$this->enviarCorreo($email, $username, $names, $password)) {
                return "Usuario creado, pero el correo no se pudo enviar";
            }
            return "Usuario registrado correctamente y correo enviado";
        }

        return "No se pudo registrar el usuario";
    }

    // Editar un usuario existente
    public function editar($id, $company_id, $username, $email, $lastname, $surname, $names, $nacionality, $role, $job_id)
    {
        $sql = "UPDATE users SET company_id='$company_id', username='$username', email='$email', lastname='$lastname', surname='$surname', names='$names', nacionality='$nacionality', role='$role', job_id='$job_id' WHERE id='$id'";

        return ejecutarConsulta($sql);
    }

    // Desactivar usuario
    // Desactivar usuario
    public function desactivar($id)
    {
        $sql = "UPDATE users SET is_active='0' WHERE id='$id'";
        return ejecutarConsulta($sql);
    }

    // Activar usuario
    public function activar($id)
    {
        $sql = "UPDATE users SET is_active='1' WHERE id='$id'";
        return ejecutarConsulta($sql);
    }


    // Mostrar datos de un usuario específico
    public function mostrar($id)
    {
        $sql = "SELECT u.*, c.company_name, c.id as company_id
                FROM users u 
                LEFT JOIN companies c ON u.company_id = c.id
                WHERE u.id='$id'";
        return ejecutarConsultaSimpleFila($sql);
    }

    // Listar empresas para el select
    public function listarEmpresas()
    {
        $sql = "SELECT id, company_name FROM companies";
        return ejecutarConsulta($sql);
    }

    // Cambiar la contraseña de un usuario específico
    public function cambiarPassword($id, $newPassword)
    {
        $password_hashed = password_hash($newPassword, PASSWORD_DEFAULT);
        $sql = "UPDATE users SET password='$password_hashed' WHERE id='$id'";
        return ejecutarConsulta($sql);
    }

    // Autenticar usuario
    public function autenticar($username, $password)
    {
        $sql = "SELECT * FROM users WHERE username = '$username' AND is_active = 1";
        $result = ejecutarConsultaSimpleFila($sql);

        if ($result && password_verify($password, $result['password'])) {
            return $result;
        } else {
            return false;
        }
    }

    // Registrar login
    public function registrarLogin($userId)
    {
        $sql = "INSERT INTO user_access_logs (user_id, access_time) VALUES ('$userId', NOW())";
        return ejecutarConsulta($sql);
    }

    // Registrar logout
    public function registrarLogout($userId)
    {
        $sql = "UPDATE user_access_logs SET logout_time = NOW() WHERE user_id = '$userId' AND logout_time IS NULL";
        return ejecutarConsulta($sql);
    }

    // Obtener historial de acceso
    public function obtenerHistorialAcceso($userId)
    {
        $sql = "SELECT access_time, logout_time FROM user_access_logs WHERE user_id = '$userId' ORDER BY access_time DESC";
        return ejecutarConsulta($sql);
    }

    // Enviar correo con la contraseña generada
    private function enviarCorreo($email, $username, $names, $password)
    {
        $mail = new PHPMailer(true);
        try {
            $mail->isSMTP();
            $mail->Host = 'mail.exclusivehosting.net';
            $mail->SMTPAuth = true;
            $mail->Username = 'cristhian.espino@andinaenergy.com';
            $mail->Password = 'AndinaEn@BP1zAPx';
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
            $mail->Port = 465;


            $mail->setFrom('cristhian.espino@andinaenergy.com', 'Andina Energy');
            $mail->addAddress($email);

            $mail->isHTML(true);
            $mail->Subject = 'Cuenta Creada - Información de Acceso';
            $mail->CharSet = 'UTF-8';

            $mail->Body = "
            <div style='font-family: Arial, sans-serif; color: #333; padding: 20px;'>
                <h2 style='color: #007bff;'>¡Bienvenido a Andina Energy, $names!</h2>
                <p style='font-size: 14px;'>Nos complace informarte que tu cuenta ha sido creada con éxito.</p>
                <p style='font-size: 16px;'><strong>Usuario:</strong> $username</p>
                <p style='font-size: 16px;'><strong>Contraseña:</strong> $password</p>
                <p style='font-size: 12px; color: #555;'>Por favor, cambia tu contraseña la primera vez que inicies sesión para asegurar tu cuenta.</p>
                <div style='margin-top: 20px;'>
                    <a href='https://andinaenergy.com/' style='background-color: #007bff; color: white; padding: 10px 15px; text-decoration: none; border-radius: 5px;'>Iniciar sesión</a>
                </div>
                <p style='font-size: 12px; color: #888; margin-top: 20px;'>Si tienes alguna pregunta o necesitas ayuda, no dudes en contactarnos.</p>
                <p style='font-size: 12px; color: #888;'>Gracias,<br>Equipo de Andina Energy</p>
            </div>";

            $mail->send();
            return true;
        } catch (Exception $e) {
            echo "Error al enviar mensaje: {$mail->ErrorInfo}";
            return false;
        }
    }
}
