<?php
require_once "../modelos/DocumentName.php";

$document = new DocumentName();

$id = isset($_POST["id"]) ? limpiarCadena($_POST["id"]) : "";
$documentName = isset($_POST["documentName"]) ? limpiarCadena($_POST["documentName"]) : "";


switch ($_GET["op"]) {
    case 'guardar':
        $rspta = $document->insertar($documentName);
        echo $rspta ? "Datos registrados correctamente" : "No se pudo registrar los datos";
        break;

    case 'editar':
        $rspta = $document->editar($id, $documentName);
        echo $rspta ? "Datos actualizados correctamente" : "No se pudo actualizar los datos";
        break;

    case 'desactivar':
        $rspta = $document->desactivar($id);
        echo $rspta ? "Datos desactivados correctamente" : "No se pudo desactivar los datos";
        break;

    case 'activar':
        $rspta = $document->activar($id);
        echo $rspta ? "Datos activados correctamente" : "No se pudo activar los datos";
        break;

    case 'mostrar':
        $rspta = $document->mostrar($id);
        echo json_encode($rspta);
        break;

    case 'listar':
        $rspta = $document->listar();
        $data = array();

        while ($reg = $rspta->fetch_object()) {
            $data[] = array(
                "0" => $reg->id,
                "1" => $reg->documentName,
                "2" => $reg->created_at,
                "3" => $reg->updated_at,
                "4" => ($reg->is_active) ? '<span class="badge badge-info">Activado</span>' : '<span class="badge badge-danger">Desactivado</span>',
                "5" => ($reg->is_active) ?
                    '<button class="btn btn-warning btn-circle btn-edit" data-toggle="modal" data-target="#formularioActualizar" data-id="' . $reg->id . '">
						<i class="icon icon-pencil"></i>
					</button>' . ' ' .
					'<button class="btn btn-danger btn-circle  btn-desactivar" data-id="' . $reg->id . '">
						<i class="mdi mdi-close-box"></i>
					</button>' :
					'<button class="btn btn-warning btn-circle  btn-edit" data-toggle="modal" data-target="#formularioActualizar" data-id="' . $reg->id . '">
						<i class="icon icon-pencil"></i>
					</button>' . ' ' .
					'<button class="btn btn-info btn-circle btn-activar" data-id="' . $reg->id . '">
						<i class="fa fa-check-square"></i>
					</button>',

            );
        }
        $results = array(
            "aaData" => $data
        );
        echo json_encode($results);
        break;
}
