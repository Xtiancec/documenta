<?php
require_once "../modelos/Companies.php";

$companies = new Companies();

$id = isset($_POST["id"]) ? limpiarCadena($_POST["id"]) : "";
$company_name = isset($_POST["company_name"]) ? limpiarCadena($_POST["company_name"]) : "";


switch ($_GET["op"]) {
	case 'guardar':
		$rspta = $companies->insertar($company_name);
		echo $rspta ? "Datos registrados correctamente" : "No se pudo registrar los datos";
		break;

	case 'editar':
		$rspta = $companies->editar($id, $company_name);
		echo $rspta ? "Datos actualizados correctamente" : "No se pudo actualizar los datos";

		break;

	case 'desactivar':
		$rspta = $companies->desactivar($id);
		echo $rspta ? "Datos desactivados correctamente" : "No se pudo desactivar los datos";
		break;
	case 'activar':
		$rspta = $companies->activar($id);
		echo $rspta ? "Datos activados correctamente" : "No se pudo activar los datos";
		break;

	case 'mostrar':
		$rspta = $companies->mostrar($id);
		echo json_encode($rspta);
		break;

	case 'listar':
		$rspta = $companies->listar();
		$data = array();

		while ($reg = $rspta->fetch_object()) {
			$data[] = array(
				"0" => $reg->id,
				"1" => $reg->company_name,
				"2" => $reg->created_at,
				"3" => $reg->updated_at,
				"4" => ($reg->is_active) ? '<span class="badge badge-success">Activado</span>' : '<span class="badge badge-danger">Desactivado</span>',
				"5" => ($reg->is_active) ?
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
}
