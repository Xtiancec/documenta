<?php
require_once "../modelos/DocumentApplicant.php";
session_start();

class DocumentUploadController {

    // Subir CV
    public function subirCv() {
        if (!isset($_SESSION['applicant_id'])) {
            echo json_encode(['status' => false, 'message' => 'Sesión no iniciada.']);
            return;
        }

        $applicant_id = $_SESSION['applicant_id'];
        $username = $_SESSION['username'];

        if (isset($_FILES['cv_file'])) {
            foreach ($_FILES['cv_file']['name'] as $index => $original_file_name) {
                $file_extension = pathinfo($original_file_name, PATHINFO_EXTENSION);
                $timestamp = date('YmdHis');
                $generated_file_name = $username . "_CV_" . $timestamp . "_" . $index . "." . $file_extension;

                $upload_dir = "../uploads/user_" . $applicant_id;
                if (!file_exists($upload_dir)) {
                    mkdir($upload_dir, 0777, true);
                }

                $document_path = $upload_dir . "/" . $generated_file_name;
                if (move_uploaded_file($_FILES['cv_file']['tmp_name'][$index], $document_path)) {
                    $documentApplicant = new DocumentApplicant();
                    $documentApplicant->insertar($applicant_id, 'CV', $original_file_name, $generated_file_name, $document_path);
                }
            }
            echo json_encode(['status' => true, 'message' => 'CV subido correctamente.']);
        } else {
            echo json_encode(['status' => false, 'message' => 'No se recibió ningún archivo.']);
        }
    }

    // Subir Otros Documentos
    public function subirOtrosDocumentos() {
        if (!isset($_SESSION['applicant_id'])) {
            echo json_encode(['status' => false, 'message' => 'Sesión no iniciada.']);
            return;
        }

        $applicant_id = $_SESSION['applicant_id'];
        $username = $_SESSION['username'];

        if (isset($_FILES['other_files'])) {
            foreach ($_FILES['other_files']['name'] as $index => $original_file_name) {
                $file_extension = pathinfo($original_file_name, PATHINFO_EXTENSION);
                $timestamp = date('YmdHis');
                $generated_file_name = $username . "_Doc_" . $timestamp . "_" . $index . "." . $file_extension;

                $upload_dir = "../uploads/user_" . $applicant_id;
                if (!file_exists($upload_dir)) {
                    mkdir($upload_dir, 0777, true);
                }

                $document_path = $upload_dir . "/" . $generated_file_name;
                if (move_uploaded_file($_FILES['other_files']['tmp_name'][$index], $document_path)) {
                    $documentApplicant = new DocumentApplicant();
                    $documentApplicant->insertar($applicant_id, 'Otro', $original_file_name, $generated_file_name, $document_path);
                }
            }
            echo json_encode(['status' => true, 'message' => 'Documentos subidos correctamente.']);
        } else {
            echo json_encode(['status' => false, 'message' => 'No se recibió ningún archivo.']);
        }
    }

    // Listar Documentos
    public function listarDocumentos() {
        if (!isset($_SESSION['applicant_id'])) {
            echo json_encode(['status' => false, 'message' => 'Sesión no iniciada.']);
            return;
        }
    
        $applicant_id = $_SESSION['applicant_id'];
        $documentApplicant = new DocumentApplicant();
        $result = $documentApplicant->listar($applicant_id);
    
        if (!empty($result)) {
            echo json_encode($result);
        } else {
            echo json_encode(['status' => false, 'message' => 'No se encontraron documentos subidos.']);
        }
    }

    // Eliminar Documento
    public function eliminarDocumento() {
        $id = isset($_POST['id']) ? limpiarCadena($_POST['id']) : 0;
        $documentApplicant = new DocumentApplicant();
        $document = $documentApplicant->mostrar($id);

        if ($document) {
            // Eliminar el archivo del servidor
            if (file_exists($document['document_path'])) {
                unlink($document['document_path']);
            }

            // Eliminar el registro de la base de datos
            $result = $documentApplicant->eliminar($id);
            echo json_encode([
                'status' => $result ? true : false,
                'message' => $result ? "Documento eliminado correctamente" : "Error al eliminar el documento"
            ]);
        } else {
            echo json_encode(['status' => false, 'message' => 'Documento no encontrado.']);
        }
    }
}

if (isset($_GET["op"])) {
    $controller = new DocumentUploadController();
    switch ($_GET["op"]) {
        case 'subirCv':
            $controller->subirCv();
            break;
        case 'subirOtrosDocumentos':
            $controller->subirOtrosDocumentos();
            break;
        case 'listarDocumentos':
            $controller->listarDocumentos();
            break;
        case 'eliminarDocumento':
            $controller->eliminarDocumento();
            break;
    }
}

?>