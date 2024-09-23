<?php
require_once '../config/Conexion.php';

class Companies {

    // Método para insertar una nueva empresa
    public function insertar($company_name, $ruc, $description)
    {
        $company_name = limpiarCadena($company_name);
        $ruc = limpiarCadena($ruc);
        $description = limpiarCadena($description);

        // Verificar si el RUC ya existe
        $sql_verificar = "SELECT id FROM companies WHERE ruc = '$ruc'";
        $rspta_verificar = ejecutarConsulta($sql_verificar);
        if ($rspta_verificar && $rspta_verificar->num_rows > 0) {
            return false; // RUC ya existe
        }

        $sql = "INSERT INTO companies (company_name, ruc, description) VALUES ('$company_name', '$ruc', '$description')";
        return ejecutarConsulta($sql);
    }

    // Método para editar una empresa existente
    public function editar($id, $company_name, $ruc, $description)
    {
        $id = limpiarCadena($id);
        $company_name = limpiarCadena($company_name);
        $ruc = limpiarCadena($ruc);
        $description = limpiarCadena($description);

        // Verificar si el RUC ya existe en otra empresa
        $sql_verificar = "SELECT id FROM companies WHERE ruc = '$ruc' AND id != '$id'";
        $rspta_verificar = ejecutarConsulta($sql_verificar);
        if ($rspta_verificar && $rspta_verificar->num_rows > 0) {
            return false; // RUC ya existe en otra empresa
        }

        $sql = "UPDATE companies SET company_name = '$company_name', ruc = '$ruc', description = '$description' WHERE id = '$id'";
        return ejecutarConsulta($sql);
    }

    // Método para desactivar una empresa
    public function desactivar($id)
    {
        $id = limpiarCadena($id);
        $sql = "UPDATE companies SET is_active = 0 WHERE id = '$id'";
        return ejecutarConsulta($sql);
    }

    // Método para activar una empresa
    public function activar($id)
    {
        $id = limpiarCadena($id);
        $sql = "UPDATE companies SET is_active = 1 WHERE id = '$id'";
        return ejecutarConsulta($sql);
    }

    // Método para mostrar una empresa específica
    public function mostrar($id)
    {
        $id = limpiarCadena($id);
        $sql = "SELECT * FROM companies WHERE id = '$id'";
        return ejecutarConsultaSimpleFila($sql);
    }

    // Método para listar todas las empresas
    public function listar()
    {
        $sql = "SELECT * FROM companies";
        return ejecutarConsulta($sql);
    }

    // Método para obtener una lista de empresas activas para un select
    public function select()
    {
        $sql = "SELECT * FROM companies WHERE is_active = 1";
        return ejecutarConsulta($sql);
    }

    // Método para verificar si un RUC ya existe
    public function verificarRuc($ruc, $id = null)
    {
        $ruc = limpiarCadena($ruc);
        if ($id) {
            $id = limpiarCadena($id);
            $sql = "SELECT id FROM companies WHERE ruc = '$ruc' AND id != '$id'";
        } else {
            $sql = "SELECT id FROM companies WHERE ruc = '$ruc'";
        }
        $result = ejecutarConsulta($sql);
        if ($result && $result->num_rows > 0) {
            return true; // RUC ya existe
        }
        return false; // RUC no existe
    }
}
?>
