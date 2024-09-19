<?php
require_once "../modelos/Applicant.php";

class ApplicantController
{
    // Guardar o actualizar postulante
    public function guardar()
    {
        $applicant = new Applicant();

        $company_id = isset($_POST["company_id"]) ? limpiarCadena($_POST["company_id"]) : "";
        $job_id = isset($_POST["job_id"]) ? limpiarCadena($_POST["job_id"]) : "";
        $username = isset($_POST["username"]) ? limpiarCadena($_POST["username"]) : "";
        $email = isset($_POST["email"]) ? limpiarCadena($_POST["email"]) : "";
        $lastname = isset($_POST["lastname"]) ? limpiarCadena($_POST["lastname"]) : "";
        $surname = isset($_POST["surname"]) ? limpiarCadena($_POST["surname"]) : "";
        $names = isset($_POST["names"]) ? limpiarCadena($_POST["names"]) : "";


        // Inserción
        $rspta = $applicant->insertar($company_id, $job_id, $username, $email, $lastname, $surname, $names);
        echo $rspta ? "Postulante registrado correctamente" : "No se pudo registrar el postulante";
    }

    public function editar()
    {
        $applicant = new Applicant();
        
        $id = isset($_POST["idUpdate"]) ? limpiarCadena($_POST["idUpdate"]) : "";
        $company_id = isset($_POST["company_idUpdate"]) ? limpiarCadena($_POST["company_idUpdate"]) : "";
        $job_id = isset($_POST["job_idUpdate"]) ? limpiarCadena($_POST["job_idUpdate"]) : "";
        $username = isset($_POST["usernameUpdate"]) ? limpiarCadena($_POST["usernameUpdate"]) : "";
        $email = isset($_POST["emailUpdate"]) ? limpiarCadena($_POST["emailUpdate"]) : "";
        $lastname = isset($_POST["lastnameUpdate"]) ? limpiarCadena($_POST["lastnameUpdate"]) : "";
        $surname = isset($_POST["surnameUpdate"]) ? limpiarCadena($_POST["surnameUpdate"]) : "";
        $names = isset($_POST["namesUpdate"]) ? limpiarCadena($_POST["namesUpdate"]) : "";
    
        // Ejecutar actualización
        $rspta = $applicant->editar($id, $company_id, $job_id, $username, $email, $lastname, $surname, $names);
    
        if ($rspta) {
            echo "Postulante actualizado correctamente";
        } else {
            echo "Error al actualizar el postulante";
        }
    }
    
    



    // Función para mostrar los datos de un postulante
    public function mostrar()
    {
        $applicant = new Applicant();
        $id = isset($_POST["id"]) ? limpiarCadena($_POST["id"]) : "";
        $rspta = $applicant->mostrar($id);
        echo json_encode($rspta);
    }
    // Función para listar los postulantes
    public function listar()
    {
        $applicant = new Applicant();
        $rspta = $applicant->listar();
        $data = array();

        while ($reg = $rspta->fetch_object()) {
            $full_name = "{$reg->lastname} {$reg->surname} {$reg->names}";
            $data[] = array(
                "0" => $reg->id,
                "1" => $reg->username,
                "2" => $reg->email,
                "3" => $full_name,
                "4" => $reg->company_name,
                "5" => $reg->position_name,
                "6" => $reg->is_active ? '<span class="badge badge-success">Activo</span>' : '<span class="badge badge-danger">Inactivo</span>',
                "7" => $reg->is_active
                    ? '<button class="btn btn-warning" onclick="mostrar(' . $reg->id . ')"><i class="fa fa-pencil"></i></button>' .
                    ' <button class="btn btn-danger" onclick="desactivar(' . $reg->id . ')"><i class="fa fa-close"></i></button>'
                    : '<button class="btn btn-primary" onclick="activar(' . $reg->id . ')"><i class="fa fa-check"></i></button>'
            );
        }

        $results = array(
            "sEcho" => 1,
            "iTotalRecords" => count($data),
            "iTotalDisplayRecords" => count($data),
            "aaData" => $data
        );

        echo json_encode($results);
    }

    // Función para desactivar postulante
    public function desactivar()
    {
        $applicant = new Applicant();
        $id = isset($_POST["id"]) ? limpiarCadena($_POST["id"]) : "";
        $rspta = $applicant->desactivar($id);
        echo $rspta ? "Postulante desactivado correctamente" : "No se pudo desactivar el postulante";
    }

    // Función para activar postulante
    public function activar()
    {
        $applicant = new Applicant();
        $id = isset($_POST["id"]) ? limpiarCadena($_POST["id"]) : "";
        $rspta = $applicant->activar($id);
        echo $rspta ? "Postulante activado correctamente" : "No se pudo activar el postulante";
    }

    // Función para listar todas las empresas
    public function listarEmpresas()
    {
        $applicant = new Applicant();
        $rspta = $applicant->listarEmpresas();
        echo json_encode($rspta->fetch_all(MYSQLI_ASSOC));
    }

    // Función para listar todos los puestos activos
    public function listarPuestosActivos()
    {
        $applicant = new Applicant();
        $rspta = $applicant->listarPuestosActivos();
        echo json_encode($rspta->fetch_all(MYSQLI_ASSOC));
    }
}

if (isset($_GET["op"])) {
    $controller = new ApplicantController();
    switch ($_GET["op"]) {
        case 'listar':
            $controller->listar();
            break;
        case 'guardar':
            $controller->guardar();
            break;
        case 'editar':
            $controller->editar();
            break;
        case 'mostrar':
            $controller->mostrar();
            break;
        case 'desactivar':
            $controller->desactivar();
            break;
        case 'activar':
            $controller->activar();
            break;
        case 'listarEmpresas':
            $controller->listarEmpresas();
            break;
        case 'listarPuestosActivos':
            $controller->listarPuestosActivos();
            break;
    }
}
