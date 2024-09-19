<?php
require_once '../config/Conexion.php';

class Companies {


    public function insertar($company_name)
    {
        $sql = "INSERT INTO companies (company_name, is_active) VALUES ('$company_name', '1')";
        return ejecutarConsulta($sql);
    }

    public function editar($id, $company_name)
    {
        $sql = "UPDATE companies SET company_name='$company_name' WHERE id='$id'";
        return ejecutarConsulta($sql);
    }

// Método para desactivar un área
public function desactivar($id)
{
    $sql = "UPDATE companies SET is_active='0' WHERE id='$id'";
    return ejecutarConsulta($sql);
}

// Método para activar un área
public function activar($id)
{
    $sql = "UPDATE companies SET is_active='1' WHERE id='$id'";
    return ejecutarConsulta($sql);
}

// Método para mostrar un registro de área
public function mostrar($id)
{
    $sql = "SELECT * FROM companies WHERE id='$id'";
    return ejecutarConsultaSimpleFila($sql);
}

// Método para listar todos los registros de áreas
public function listar()
{
    $sql = "SELECT * FROM companies";
    return ejecutarConsulta($sql);
}

// Método para obtener una lista de áreas activas para usar en un select
public function select()
{
    $sql = "SELECT * FROM companies WHERE is_active=1";
    return ejecutarConsulta($sql);
}

}
?>
