<?php
require "../config/Conexion.php";

class DocumentMandatory
{
    // Insertar un nuevo registro en mandatory_documents
    public function insertar($position_id, $document_type, $documentName_id)
    {
        $sql = "INSERT INTO mandatory_documents (position_id, document_type, documentName_id, is_active) 
                VALUES ('$position_id', '$document_type', '$documentName_id', '1')";
        return ejecutarConsulta($sql);
    }

    // Editar un registro existente en mandatory_documents
    public function editar($id, $position_id, $document_type, $documentName_id)
    {
        $sql = "UPDATE mandatory_documents 
                SET position_id='$position_id', document_type='$document_type', documentName_id='$documentName_id'
                WHERE id='$id'";
        return ejecutarConsulta($sql);
    }

    // Desactivar un registro (cambiar is_active a 0)
    public function desactivar($id)
    {
        $sql = "UPDATE mandatory_documents SET is_active='0' WHERE id='$id'";
        return ejecutarConsulta($sql);
    }

    // Activar un registro (cambiar is_active a 1)
    public function activar($id)
    {
        $sql = "UPDATE mandatory_documents SET is_active='1' WHERE id='$id'";
        return ejecutarConsulta($sql);
    }

    // Mostrar un registro específico por su id
    public function mostrar($id)
    {
        $sql = "SELECT * FROM mandatory_documents WHERE id='$id'";
        return ejecutarConsultaSimpleFila($sql);
    }

    // Listar todos los documentos junto con sus puestos y nombres
    public function listar()
    {
        $sql = "SELECT 
                    mandatory_documents.id,
                    mandatory_documents.document_type,
                    mandatory_documents.created_at,
                    mandatory_documents.updated_at,
                    mandatory_documents.is_active,
                    job_positions.position_name,
                    document_name.documentName
                FROM mandatory_documents
                INNER JOIN job_positions ON job_positions.id = mandatory_documents.position_id
                INNER JOIN document_name ON document_name.id = mandatory_documents.documentName_id";
        return ejecutarConsulta($sql);
    }

    // Listar todos los documentos activos
    public function listarDocumentosActivos()
    {
        $sql = "SELECT * FROM document_name WHERE is_active = '1'";
        return ejecutarConsulta($sql);
    }

    // Listar documentos asignados a un puesto específico
    public function listarDocumentosAsignados($position_id)
    {
        $sql = "SELECT 
                    document_name.id AS document_id,
                    document_name.documentName,
                    mandatory_documents.document_type,
                    IF(mandatory_documents.position_id IS NOT NULL, 1, 0) AS asignado
                FROM document_name
                LEFT JOIN mandatory_documents 
                    ON mandatory_documents.documentName_id = document_name.id 
                    AND mandatory_documents.position_id = '$position_id' 
                    AND mandatory_documents.is_active = '1'
                WHERE document_name.is_active = '1'";

        return ejecutarConsulta($sql);
    }

    // Listar todos los puestos junto con los documentos asignados
    public function listarPuestosConDocumentos()
    {
        $sql = "SELECT 
                    job_positions.position_name,
                    document_name.documentName,
                    mandatory_documents.document_type,
                    mandatory_documents.created_at,
                    mandatory_documents.updated_at
                FROM mandatory_documents
                INNER JOIN job_positions ON job_positions.id = mandatory_documents.position_id
                INNER JOIN document_name ON document_name.id = mandatory_documents.documentName_id
                WHERE mandatory_documents.is_active = '1'
                ORDER BY job_positions.position_name, mandatory_documents.document_type";
        return ejecutarConsulta($sql);
    }

    // Verificar si ya existe una asignación de documento para un puesto específico
    public function verificarExistencia($position_id, $documentName_id)
    {
        $sql = "SELECT id FROM mandatory_documents 
                WHERE position_id = '$position_id' AND documentName_id = '$documentName_id' AND is_active = '1'";
        return ejecutarConsultaSimpleFila($sql);
    }

    // Listar todos los puestos activos
    public function listarPuestosActivos()
    {
        $sql = "SELECT id, position_name 
                FROM job_positions 
                WHERE is_active = 1";
        return ejecutarConsulta($sql);
    }

    public function selectByCompany($company_id)
    {
        $sql = "SELECT id, position_name FROM job_positions WHERE company_id = '$company_id' AND is_active = 1";
        return ejecutarConsulta($sql);
    }

    public function listarPuestosConDocumentosPorEmpresa()
    {
        $sql = "SELECT 
                    companies.company_name,
                    job_positions.position_name,
                    document_name.documentName,
                    mandatory_documents.document_type,
                    mandatory_documents.created_at,
                    mandatory_documents.updated_at
                FROM mandatory_documents
                INNER JOIN job_positions ON job_positions.id = mandatory_documents.position_id
                INNER JOIN document_name ON document_name.id = mandatory_documents.documentName_id
                INNER JOIN companies ON companies.id = job_positions.company_id
                WHERE mandatory_documents.is_active = '1'
                ORDER BY companies.company_name, job_positions.position_name, mandatory_documents.document_type";
        return ejecutarConsulta($sql);
    }

    public function listarPuestosConDocumentosPorEmpresaCompleto()
    {
        $sql = "SELECT 
                    companies.company_name,
                    job_positions.position_name,
                    document_name.documentName,
                    mandatory_documents.document_type,
                    mandatory_documents.created_at,
                    mandatory_documents.updated_at,
                    mandatory_documents.id AS doc_asignado
                FROM job_positions
                LEFT JOIN mandatory_documents 
                    ON job_positions.id = mandatory_documents.position_id 
                    AND mandatory_documents.is_active = '1'
                LEFT JOIN document_name 
                    ON mandatory_documents.documentName_id = document_name.id
                INNER JOIN companies 
                    ON companies.id = job_positions.company_id
                WHERE job_positions.is_active = '1'
                ORDER BY companies.company_name, job_positions.position_name, mandatory_documents.document_type";
        return ejecutarConsulta($sql);
    }
}
