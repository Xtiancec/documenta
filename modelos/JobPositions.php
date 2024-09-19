<?php
// Incluir la conexión a la base de datos
require "../config/Conexion.php";

class JobPositions
{
    // Método para insertar un nuevo registro de clase
    public function insertar($position_name, $company_id)
    {
        $sql = "INSERT INTO job_positions (position_name, company_id, is_active) VALUES ('$position_name','$company_id', '1')";
        return ejecutarConsulta($sql);
    }

    // Método para editar un registro de clase
    public function editar($id, $position_name, $company_id)
    {
        $sql = "UPDATE job_positions 
        SET position_name='$position_name',company_id='$company_id' 
        WHERE id='$id'";

        return ejecutarConsulta($sql);
    }

    // Método para desactivar una clase
    public function desactivar($id)
    {
        $sql = "UPDATE job_positions SET is_active='0' WHERE id='$id'";
        return ejecutarConsulta($sql);
    }

    // Método para activar una clase
    public function activar($id)
    {
        $sql = "UPDATE job_positions SET is_active='1' WHERE id='$id'";
        return ejecutarConsulta($sql);
    }

    // Método para mostrar un registro de clase
    public function mostrar($id)
    {
        $sql = "SELECT * FROM job_positions WHERE id='$id'";
        return ejecutarConsultaSimpleFila($sql);
    }

    // Método para listar todos los registros de clases
    public function listar()
    {
        $sql = "SELECT 
        job_positions.id,
        job_positions.position_name,
        job_positions.is_active,
        job_positions.created_at,
        job_positions.updated_at,
        companies.company_name
        from job_positions
        INNER JOIN companies on job_positions.company_id=companies.id";

        return ejecutarConsulta($sql);
    }
    public function listarPuestosActivos()
    {
        $sql = "SELECT id, position_name FROM job_positions WHERE is_active = 1";
        return ejecutarConsulta($sql);
    }
    // Método para obtener una lista de clases activas para usar en un select
    public function select()
    {
        $sql = "SELECT 
        job_positions.id,
        job_positions.position_name,
        job_positions.is_active,
        job_positions.created_at,
        job_positions.updated_at,
        companies.company_name
        from job_positions
        INNER JOIN companies on job_positions.company_id=companies.id
        WHERE job_positions.is_active='1'";

        return ejecutarConsulta($sql);
    }

    public function selectByCompany($company_id) {
        $sql = "SELECT id, position_name FROM job_positions WHERE company_id = '$company_id' AND is_active = 1";
        return ejecutarConsulta($sql);
    }
}
