    <?php
    require "../config/Conexion.php";

    class DocumentApplicant
    {
        // Insertar documento en la base de datos
        public function insertar($applicant_id, $document_name, $original_file_name, $generated_file_name, $document_path)
        {
            // Estado inicial 'Subido' tiene el ID correspondiente en la tabla document_states (por ejemplo, 1 para 'Subido')
            $state_id = 1; // Asegúrate de que este ID corresponde al estado 'Subido' en la tabla `document_states`.

            $sql = "INSERT INTO documents_applicants (applicant_id, document_name, original_file_name, generated_file_name, document_path, state_id, created_at) 
                    VALUES ('$applicant_id', '$document_name', '$original_file_name', '$generated_file_name', '$document_path', '$state_id', CURRENT_TIMESTAMP)";

            return ejecutarConsulta($sql);
        }

        // Listar todos los documentos de un postulante
        public function listar($applicant_id)
        {
            $sql = "SELECT * FROM documents_applicants WHERE applicant_id = '$applicant_id'";
            $result = ejecutarConsulta($sql);

            if ($result) {
                $rows = [];
                while ($row = $result->fetch_assoc()) {
                    $rows[] = $row;
                }
                return $rows;
            } else {
                return [];
            }
        }

        // Eliminar documento por ID
        public function eliminar($id)
        {
            $sql = "DELETE FROM documents_applicants WHERE id = '$id'";
            return ejecutarConsulta($sql);
        }

        // Mostrar detalles de un documento por ID
        public function mostrar($id)
        {
            $sql = "SELECT * FROM documents_applicants WHERE id = '$id'";
            return ejecutarConsultaSimpleFila($sql);
        }

        // Listar todos los documentos de los postulantes
        public function listarTodos()
        {
            $sql = "SELECT d.id, 
                        a.names AS applicant_name, 
                        d.document_name, 
                        d.created_at, 
                        d.uploaded_at, 
                        d.admin_observation, 
                        d.admin_reviewed, 
                        d.document_path, 
                        s.state_name,  -- Aquí incluimos el nombre del estado del documento
                        j.position_name, 
                        c.company_name
                    FROM documents_applicants d
                    JOIN applicants a ON d.applicant_id = a.id
                    JOIN document_states s ON d.state_id = s.id  -- Asegúrate de unirte con la tabla de estados
                    JOIN job_positions j ON a.job_id = j.id
                    JOIN companies c ON j.company_id = c.id
                    ORDER BY d.uploaded_at DESC";

            $result = ejecutarConsulta($sql);

            if ($result) {
                $rows = [];
                while ($row = $result->fetch_assoc()) {
                    $rows[] = $row;
                }
                return $rows;
            } else {
                return null;
            }
        }

        // Obtener un documento por su ID
        public function obtenerDocumentoPorId($id)
        {
            $sql = "SELECT d.id, a.names AS applicant_name, d.document_name, d.document_path, d.uploaded_at, d.admin_observation, d.admin_reviewed, s.state_name 
                    FROM documents_applicants d
                    JOIN applicants a ON d.applicant_id = a.id
                    JOIN document_states s ON d.state_id = s.id
                    WHERE d.id = ?";
            return ejecutarConsultaSimpleFila($sql, array($id));
        }

        // Marcar documento como revisado
        public function marcarRevisado($id)
        {
            // Cambiar el estado del documento a "Revisado" (state_id = 2)
            $sql = "UPDATE documents_applicants SET state_id = 2, admin_reviewed = 1 WHERE id = ?";
            
            global $conexion;
        
            if ($stmt = $conexion->prepare($sql)) {
                $stmt->bind_param('i', $id); // Vincular el parámetro $id
                return $stmt->execute();
            } else {
                echo "Error en la preparación de la consulta: " . $conexion->error;
                return false;
            }
        }
        

        // Evaluar el documento
        public function evaluarDocumento($id, $admin_observation, $state_id)
        {
            // Consulta SQL con placeholders para los parámetros
            $sql = "UPDATE documents_applicants 
                    SET admin_observation = ?, state_id = ?, admin_reviewed = 1
                    WHERE id = ?";
            
            // Prepara la consulta
            global $conexion;
            if ($stmt = $conexion->prepare($sql)) {
                // Vincular parámetros
                $stmt->bind_param('sii', $admin_observation, $state_id, $id); // 'sii' -> String, Integer, Integer
                
                // Ejecutar la consulta
                if ($stmt->execute()) {
                    return true;
                } else {
                    echo "Error en la consulta: " . $stmt->error;
                    return false;
                }
            } else {
                echo "Error en la preparación de la consulta: " . $conexion->error;
                return false;
            }
        }
        
        
        
    }
