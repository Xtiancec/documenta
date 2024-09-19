<?php
require_once "../modelos/DocumentUpload.php";
$documentUpload = new DocumentUpload();

switch ($_GET["op"]) {
    case 'listarPuestosActivos':
        $rspta = $documentUpload->listarPuestosActivos();
        echo json_encode($rspta->fetch_all(MYSQLI_ASSOC));
        break;

    case 'listarDocumentosPorPuesto':
        $position_id = $_POST['position_id'];
        $rspta = $documentUpload->listarDocumentosPorPuesto($position_id);
        echo json_encode($rspta->fetch_all(MYSQLI_ASSOC));
        break;

    case 'subirDocumento':
        if (!empty($_FILES)) {
            foreach ($_FILES as $key => $file) {
                $document_name = $file['name'];
                $document_path = "../uploads/" . $document_name;

                // Extraer el document_id del nombre del input
                $document_id = str_replace('document_', '', $key);

                // Obtener los datos adicionales del formulario
                $user_id = $_POST['user_id'];
                $document_type = $_POST["document_type_" . $document_id];
                $category_id = $_POST["category_id_" . $document_id];
                $state_id = 1;
                
                // Obtener el comentario asociado al documento
                $user_observation = $_POST["comment_" . $document_id];

                // Mover el archivo subido al directorio de uploads
                if (move_uploaded_file($file['tmp_name'], $document_path)) {
                    // Guardar la información del documento en la base de datos, incluyendo el comentario
                    $rspta = $documentUpload->subirDocumento($user_id, $document_type, $document_name, $document_path, $category_id, $user_observation, $state_id);
                    echo $rspta ? "Documento subido correctamente." : "No se pudo subir el documento.";
                } else {
                    echo "Error al mover el archivo.";
                }
            }
        } else {
            echo "No se recibió ningún archivo.";
        }
        break;
}
?>
