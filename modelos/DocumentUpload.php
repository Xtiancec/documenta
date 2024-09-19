<?php
require_once "../config/Conexion.php";

class DocumentUpload
{
    // Método para insertar un documento subido por un usuario
    public function subirDocumento($user_id, $document_type, $document_name, $document_path, $category_id, $user_observation, $state_id) {
        $sql = "INSERT INTO documents (user_id, document_type, document_name, document_path, category_id, user_observation, state_id) 
                VALUES ('$user_id', '$document_type', '$document_name', '$document_path', '$category_id', '$user_observation', '$state_id')";
        return ejecutarConsulta($sql);
    }
    
    // Método para listar los documentos asignados a un puesto en particular
    public function listarDocumentosPorPuesto($position_id)
    {
        $sql = "SELECT md.document_type, dn.documentName, md.id AS document_id
                FROM mandatory_documents md
                INNER JOIN document_name dn ON md.documentName_id = dn.id
                WHERE md.position_id = '$position_id' AND md.is_active = 1";
        return ejecutarConsulta($sql);
    }

    // Método para listar los puestos activos
    public function listarPuestosActivos()
    {
        $sql = "SELECT id, position_name 
                FROM job_positions 
                WHERE is_active = 1";
        return ejecutarConsulta($sql);
    }
}
?>
