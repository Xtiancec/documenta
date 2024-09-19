<?php
require_once '../config/Conexion.php';

class DocumentName
{

    public function insertar($documentName)
    {
        $sql = "INSERT INTO document_name (documentName, is_active) VALUES ('$documentName', '1')";
        return ejecutarConsulta($sql);
    }

    public function editar($id, $documentName)
    {
        $sql = "UPDATE document_name SET documentName='$documentName' WHERE id='$id'";
        return ejecutarConsulta($sql);
    }

    // Método para desactivar un área
    public function desactivar($id)
    {
        $sql = "UPDATE document_name SET is_active='0' WHERE id='$id'";
        return ejecutarConsulta($sql);
    }

    // Método para activar un área
    public function activar($id)
    {
        $sql = "UPDATE document_name SET is_active='1' WHERE id='$id'";
        return ejecutarConsulta($sql);
    }

    // Método para mostrar un registro de área
    public function mostrar($id)
    {
        $sql = "SELECT * FROM document_name WHERE id='$id'";
        return ejecutarConsultaSimpleFila($sql);
    }

    // Método para listar todos los registros de áreas
    public function listar()
    {
        $sql = "SELECT * FROM document_name";
        return ejecutarConsulta($sql);
    }

    // Método para obtener una lista de áreas activas para usar en un select
    public function select()
    {
        $sql = "SELECT * FROM document_name WHERE is_active=1";
        return ejecutarConsulta($sql);
    }
}
