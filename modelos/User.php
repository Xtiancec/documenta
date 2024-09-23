<?php
// User.php

class User
{
    // Función para listar todos los usuarios
    public function listar()
    {
        $sql = "SELECT u.id, c.company_name, a.area_name, j.position_name, 
                       u.identification_number, u.lastname, u.surname, u.names, 
                       u.email, u.role, u.is_active
                FROM users u
                INNER JOIN companies c ON u.company_id = c.id
                INNER JOIN areas a ON u.area_id = a.id
                INNER JOIN jobs j ON u.job_id = j.id";
        return ejecutarConsulta($sql);
    }

    // Función para insertar un nuevo usuario
    public function insertar($company_id, $area_id, $identification_type, $identification_number, $username, $email, $lastname, $surname, $names, $nacionality, $role, $job_id, $is_employee)
    {
        // Verificar si el número de identificación o el nombre de usuario ya existen
        $sql_verificar = "SELECT id FROM users WHERE identification_number = ? OR username = ?";
        $params_verificar = [$identification_number, $username];
        $result_verificar = ejecutarConsultaSimpleFila($sql_verificar, $params_verificar);
        if ($result_verificar) {
            return "El número de identificación o nombre de usuario ya está registrado.";
        }

        // Insertar el nuevo usuario
        $sql_insertar = "INSERT INTO users (company_id, area_id, identification_type, identification_number, username, email, lastname, surname, names, nacionality, role, job_id, is_employee)
                         VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $params_insertar = [$company_id, $area_id, $identification_type, $identification_number, $username, $email, $lastname, $surname, $names, $nacionality, $role, $job_id, $is_employee];
        $result_insertar = ejecutarConsulta($sql_insertar, $params_insertar);
        if ($result_insertar) {
            return "Usuario registrado correctamente.";
        } else {
            return "Error al registrar el usuario.";
        }
    }

    // Función para editar un usuario existente
    public function editar($id, $company_id, $area_id, $identification_type, $identification_number, $username, $email, $lastname, $surname, $names, $nacionality, $role, $job_id, $is_employee)
    {
        // Verificar si el número de identificación o el nombre de usuario ya existen para otro usuario
        $sql_verificar = "SELECT id FROM users WHERE (identification_number = ? OR username = ?) AND id != ?";
        $params_verificar = [$identification_number, $username, $id];
        $result_verificar = ejecutarConsultaSimpleFila($sql_verificar, $params_verificar);
        if ($result_verificar) {
            return "El número de identificación o nombre de usuario ya está registrado por otro usuario.";
        }

        // Actualizar el usuario
        $sql_editar = "UPDATE users SET company_id = ?, area_id = ?, identification_type = ?, identification_number = ?, username = ?, email = ?, lastname = ?, surname = ?, names = ?, nationality = ?, role = ?, job_id = ?, is_employee = ?
                       WHERE id = ?";
        $params_editar = [$company_id, $area_id, $identification_type, $identification_number, $username, $email, $lastname, $surname, $names, $nacionality, $role, $job_id, $is_employee, $id];
        $result_editar = ejecutarConsulta($sql_editar, $params_editar);
        if ($result_editar) {
            return "Usuario actualizado correctamente.";
        } else {
            return "Error al actualizar el usuario.";
        }
    }

    // Función para mostrar un usuario específico
    public function mostrar($id)
    {
        $sql = "SELECT * FROM users WHERE id = ?";
        $params = [$id];
        return ejecutarConsultaSimpleFila($sql, $params);
    }

    // Función para activar un usuario
    public function activar($id)
    {
        $sql = "UPDATE users SET is_active = 1 WHERE id = ?";
        $params = [$id];
        $result = ejecutarConsulta($sql, $params);
        if ($result) {
            return "Usuario activado correctamente.";
        } else {
            return "No se pudo activar el usuario.";
        }
    }

    // Función para desactivar un usuario
    public function desactivar($id)
    {
        $sql = "UPDATE users SET is_active = 0 WHERE id = ?";
        $params = [$id];
        $result = ejecutarConsulta($sql, $params);
        if ($result) {
            return "Usuario desactivado correctamente.";
        } else {
            return "No se pudo desactivar el usuario.";
        }
    }

    // Función para listar Áreas por Empresa
    public function listarAreasPorEmpresa($company_id)
    {
        $sql = "SELECT id, area_name FROM areas WHERE company_id = ?";
        $params = [$company_id];
        return ejecutarConsulta($sql, $params);
    }

    // Función para listar Puestos por Área
    public function listarPuestosPorArea($area_id)
    {
        $sql = "SELECT id, position_name FROM jobs WHERE area_id = ?";
        $params = [$area_id];
        return ejecutarConsulta($sql, $params);
    }

    // Función para listar todas las empresas
    public function listarEmpresas()
    {
        $sql = "SELECT id, company_name FROM companies";
        return ejecutarConsulta($sql);
    }

    // Función para listar todos los puestos de trabajo activos
    public function listarPuestosActivos()
    {
        $sql = "SELECT id, position_name FROM jobs WHERE is_active = 1";
        return ejecutarConsulta($sql);
    }

    // Función para obtener el historial de accesos de un usuario
    public function obtenerHistorialAcceso($userId)
    {
        $sql = "SELECT access_time, logout_time FROM access_history WHERE user_id = ? ORDER BY access_time DESC";
        $params = [$userId];
        return ejecutarConsulta($sql, $params);
    }

    // Función para cambiar la contraseña de un usuario
    public function cambiarPassword($id, $newPassword)
    {
        // Hash de la contraseña
        $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

        $sql = "UPDATE users SET password = ? WHERE id = ?";
        $params = [$hashedPassword, $id];
        $result = ejecutarConsulta($sql, $params);
        if ($result) {
            return "Contraseña actualizada correctamente.";
        } else {
            return "No se pudo actualizar la contraseña.";
        }
    }

    // Función para verificar duplicados de identificación_number
    public function verificarDuplicadoIdentificationNumber($identification_number, $identification_type, $userId = null)
    {
        if ($userId) {
            $sql = "SELECT id FROM users WHERE identification_number = ? AND identification_type = ? AND id != ?";
            $params = [$identification_number, $identification_type, $userId];
        } else {
            $sql = "SELECT id FROM users WHERE identification_number = ? AND identification_type = ?";
            $params = [$identification_number, $identification_type];
        }

        $result = ejecutarConsultaSimpleFila($sql, $params);
        return $result ? true : false;
    }

    // Función para verificar duplicados de username
    public function verificarDuplicadoUsername($username, $userId = null)
    {
        if ($userId) {
            $sql = "SELECT id FROM users WHERE username = ? AND id != ?";
            $params = [$username, $userId];
        } else {
            $sql = "SELECT id FROM users WHERE username = ?";
            $params = [$username];
        }

        $result = ejecutarConsultaSimpleFila($sql, $params);
        return $result ? true : false;
    }
}
?>
