<?php
require_once "../modelos/JobPositions.php";

$jobPositions = new JobPositions();

$id = isset($_POST["id"]) ? limpiarCadena($_POST["id"]) : "";
$position_name = isset($_POST["position_name"]) ? limpiarCadena($_POST["position_name"]) : "";
$company_id = isset($_POST["company_id"]) ? limpiarCadena($_POST["company_id"]) : "";


switch ($_GET["op"]) {

    case 'guardar':
        $rspta = $jobPositions->insertar($position_name, $company_id);
        echo $rspta ? "Datos registrados correctamente" : "No se pudo registrar los datos";
        break;

    case 'editar':
        $rspta = $jobPositions->editar($id, $position_name, $company_id);
        echo $rspta ? "Datos actualizados correctamente" : "No se pudo actualizar los datos";
        break;

    case 'desactivar':
        $rspta = $jobPositions->desactivar($id);
        echo $rspta ? "Datos desactivados correctamente" : "No se pudo desactivar los datos";
        break;

    case 'activar':
        $rspta = $jobPositions->activar($id);
        echo $rspta ? "Datos activados correctamente" : "No se pudo activar los datos";
        break;

    case 'mostrar':
        $rspta = $jobPositions->mostrar($id);
        echo json_encode($rspta);
        break;

    case 'listar':
        $rspta = $jobPositions->listar();
        $data = array();

        while ($reg = $rspta->fetch_object()) {
            $data[] = array(
                "0" => $reg->id,
                "1" => $reg->company_name,
                "2" => $reg->position_name,
                "3" => $reg->created_at,
                "4" => $reg->updated_at,
                "5" => ($reg->is_active) ? '<span class="badge badge-success">Activado</span>' : '<span class="badge badge-danger">Desactivado</span>',
                "6" => ($reg->is_active) ?

                    '<button class="btn btn-warning btn-xs btn-edit" data-toggle="modal" data-target="#formularioActualizar" data-id="' . $reg->id . '">
						<i class="fa fa-edit"></i>
					</button>' . ' ' .
					'<button class="btn btn-danger btn-xs btn-desactivar" data-id="' . $reg->id . '">
						<i class="fa fa-window-close"></i>
					</button>' :
					'<button class="btn btn-warning btn-xs btn-edit" data-toggle="modal" data-target="#formularioActualizar" data-id="' . $reg->id . '">
						<i class="fa fa-edit"></i>
					</button>' . ' ' .
					'<button class="btn btn-primary btn-xs btn-activar" data-id="' . $reg->id . '">
						<i class="fa fa-check-square"></i>
					</button>',

            );
        }
        $results = array(
            
            "aaData" => $data
        );
        echo json_encode($results);
        break;

    case 'selectCompany':
        require_once "../modelos/Companies.php";
        $company = new Companies();

        $rspta = $company->select();

        while ($reg = $rspta->fetch_object()) {
            echo '<option value=' . $reg->id . '>' . $reg->company_name . '</option>';
        }
        break;

        
}
