<?php
require_once '../config/Conexion.php';

class Jobs {

    // Método para insertar un nuevo puesto de trabajo
    public function insertar($position_name, $area_id)
    {
        $position_name = limpiarCadena($position_name);
        $area_id = limpiarCadena($area_id);

        // Verificar si el puesto ya existe en el área
        $sql_verificar = "SELECT id FROM jobs WHERE position_name = '$position_name' AND area_id = '$area_id'";
        $rspta_verificar = ejecutarConsulta($sql_verificar);
        if ($rspta_verificar && $rspta_verificar->num_rows > 0) {
            return false; // Puesto ya existe
        }

        $sql = "INSERT INTO jobs (position_name, area_id) VALUES ('$position_name', '$area_id')";
        return ejecutarConsulta($sql);
    }

    // Método para editar un puesto de trabajo existente
    public function editar($id, $position_name, $area_id)
    {
        $id = limpiarCadena($id);
        $position_name = limpiarCadena($position_name);
        $area_id = limpiarCadena($area_id);

        // Verificar si el puesto ya existe en el área
        $sql_verificar = "SELECT id FROM jobs WHERE position_name = '$position_name' AND area_id = '$area_id' AND id != '$id'";
        $rspta_verificar = ejecutarConsulta($sql_verificar);
        if ($rspta_verificar && $rspta_verificar->num_rows > 0) {
            return false; // Puesto ya existe en otra entrada
        }

        $sql = "UPDATE jobs SET position_name = '$position_name', area_id = '$area_id' WHERE id = '$id'";
        return ejecutarConsulta($sql);
    }

    // Método para desactivar un puesto de trabajo
    public function desactivar($id)
    {
        $id = limpiarCadena($id);
        $sql = "UPDATE jobs SET is_active = 0 WHERE id = '$id'";
        return ejecutarConsulta($sql);
    }

    // Método para activar un puesto de trabajo
    public function activar($id)
    {
        $id = limpiarCadena($id);
        $sql = "UPDATE jobs SET is_active = 1 WHERE id = '$id'";
        return ejecutarConsulta($sql);
    }

    // Método para mostrar un puesto de trabajo específico
    public function mostrar($id)
    {
        $id = limpiarCadena($id);
        $sql = "SELECT j.*, a.area_name, c.company_name, a.company_id FROM jobs j 
                INNER JOIN areas a ON j.area_id = a.id 
                INNER JOIN companies c ON a.company_id = c.id 
                WHERE j.id = '$id'";
        return ejecutarConsultaSimpleFila($sql);
    }

    // Método para listar todos los puestos de trabajo
    public function listar()
    {
        $sql = "SELECT j.*, a.area_name, c.company_name FROM jobs j 
                INNER JOIN areas a ON j.area_id = a.id 
                INNER JOIN companies c ON a.company_id = c.id";
        return ejecutarConsulta($sql);
    }

    // Método para obtener una lista de puestos de trabajo activos para un select
    public function select($area_id = null)
    {
        if ($area_id) {
            $area_id = limpiarCadena($area_id);
            $sql = "SELECT * FROM jobs WHERE is_active = 1 AND area_id = '$area_id'";
        } else {
            $sql = "SELECT * FROM jobs WHERE is_active = 1";
        }
        return ejecutarConsulta($sql);
    }

    // Método para verificar si un puesto de trabajo ya existe
    public function verificarPuesto($position_name, $area_id, $id = null)
    {
        $position_name = limpiarCadena($position_name);
        $area_id = limpiarCadena($area_id);
        if ($id) {
            $id = limpiarCadena($id);
            $sql = "SELECT id FROM jobs WHERE position_name = '$position_name' AND area_id = '$area_id' AND id != '$id'";
        } else {
            $sql = "SELECT id FROM jobs WHERE position_name = '$position_name' AND area_id = '$area_id'";
        }
        $result = ejecutarConsulta($sql);
        if ($result && $result->num_rows > 0) {
            return true; // Puesto ya existe
        }
        return false; // Puesto no existe
    }

    // **Nueva Función para Listar Puestos por Área**
    public function listar_por_area($area_id)
    {
        $area_id = limpiarCadena($area_id);
        $sql = "SELECT id, position_name FROM jobs WHERE is_active = 1 AND area_id = '$area_id' ORDER BY position_name ASC";
        return ejecutarConsulta($sql);
    }

    public function listarFiltrado($company_id, $area_id, $position_id)
{
    $sql = "SELECT j.*, a.area_name, c.company_name FROM jobs j 
            INNER JOIN areas a ON j.area_id = a.id 
            INNER JOIN companies c ON a.company_id = c.id 
            WHERE 1=1";

    if (!empty($company_id)) {
        $sql .= " AND c.id = '$company_id'";
    }

    if (!empty($area_id)) {
        $sql .= " AND a.id = '$area_id'";
    }

    if (!empty($position_id)) {
        $sql .= " AND j.id = '$position_id'";
    }

    return ejecutarConsulta($sql);
}

}
?>
