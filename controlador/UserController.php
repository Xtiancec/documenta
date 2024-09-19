<?php
require_once "../config/Conexion.php";        // Usar require_once
require_once "../modelos/User.php";           // Usar require_once
require_once "../modelos/JobPositions.php";   // Usar require_once
class UserController
{
    public function __construct() {}

    // Función para listar todos los usuarios
    public function listar()
    {
        $user = new User();
        $result = $user->listar();

        $data = array();
        while ($reg = $result->fetch_object()) {
            $full_name = "{$reg->lastname} {$reg->surname} {$reg->names}";
            $data[] = array(
                "0" => $reg->id,
                "1" => $reg->company_name,
                "2" => $reg->position_name,
                "3" => $reg->username,
                "4" => $full_name,
                "5" => $reg->email,                
                "6" => $reg->role,
                "7" => $reg->is_active ? '<span class="badge badge-success">Activo</span>' : '<span class="badge badge-danger">Inactivo</span>',
                "8" => $reg->is_active
                    ? '<button class="btn btn-warning" onclick="mostrar(' . $reg->id . ')"><i class="fa fa-pencil"></i></button>' .
                    ' <button class="btn btn-danger" onclick="desactivar(' . $reg->id . ')"><i class="fa fa-close"></i></button>' .
                    ' <button class="btn btn-info" onclick="mostrarHistorial(' . $reg->id . ')"><i class="fa fa-clock-o"></i></button>'
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

    // Función para guardar o editar un usuario
    public function insertar()
    {
        $user = new User();

        $company_id = isset($_POST["company_id"]) ? limpiarCadena($_POST["company_id"]) : "";
        $username = isset($_POST["username"]) ? limpiarCadena($_POST["username"]) : "";
        $email = isset($_POST["email"]) ? limpiarCadena($_POST["email"]) : "";
        $lastname = isset($_POST["lastname"]) ? limpiarCadena($_POST["lastname"]) : "";
        $surname = isset($_POST["surname"]) ? limpiarCadena($_POST["surname"]) : "";
        $names = isset($_POST["names"]) ? limpiarCadena($_POST["names"]) : "";
        $nacionality = isset($_POST["nacionality"]) ? limpiarCadena($_POST["nacionality"]) : "";
        $role = isset($_POST["role"]) ? limpiarCadena($_POST["role"]) : "";
        $job_id = isset($_POST["job_id"]) ? limpiarCadena($_POST["job_id"]) : "";

        $rspta = $user->insertar($company_id, $username, $email, $lastname, $surname, $names, $nacionality, $role, $job_id);
        echo $rspta ? "Usuario registrado correctamente" : "No se pudo registrar el usuario";
    }


    public function actualizar()
    {
        $user = new User();

        $id = isset($_POST["idUpdate"]) ? limpiarCadena($_POST["idUpdate"]) : "";
        $company_id = isset($_POST["company_idUpdate"]) ? limpiarCadena($_POST["company_idUpdate"]) : "";
        $username = isset($_POST["usernameUpdate"]) ? limpiarCadena($_POST["usernameUpdate"]) : "";
        $email = isset($_POST["emailUpdate"]) ? limpiarCadena($_POST["emailUpdate"]) : "";
        $lastname = isset($_POST["lastnameUpdate"]) ? limpiarCadena($_POST["lastnameUpdate"]) : "";
        $surname = isset($_POST["surnameUpdate"]) ? limpiarCadena($_POST["surnameUpdate"]) : "";
        $names = isset($_POST["namesUpdate"]) ? limpiarCadena($_POST["namesUpdate"]) : "";
        $nacionality = isset($_POST["nacionalityUpdate"]) ? limpiarCadena($_POST["nacionalityUpdate"]) : "";
        $role = isset($_POST["roleUpdate"]) ? limpiarCadena($_POST["roleUpdate"]) : "";
        $job_id = isset($_POST["job_idUpdate"]) ? limpiarCadena($_POST["job_idUpdate"]) : "";

        // Depurar los valores recibidos
        error_log("Valores recibidos para actualizar - ID: $id, Company ID: $company_id, Job ID: $job_id, Username: $username, Email: $email");

        $rspta = $user->editar($id, $company_id, $username, $email, $lastname, $surname, $names, $nacionality, $role, $job_id);

        if ($rspta) {
            echo "Usuario actualizado correctamente";
        } else {
            echo "Error al actualizar el usuario";
        }
    }


    // Función para mostrar un usuario específico
    public function mostrar()
    {
        $user = new User();
        $id = isset($_POST["id"]) ? limpiarCadena($_POST["id"]) : "";
        $rspta = $user->mostrar($id);
        echo json_encode($rspta);
    }

    // Función para desactivar un usuario
    // Función para activar un usuario
    public function activar()
    {
        $user = new User();
        $id = isset($_POST["id"]) ? limpiarCadena($_POST["id"]) : "";
        $rspta = $user->activar($id);
        echo $rspta ? "Usuario activado correctamente" : "No se pudo activar el usuario";
    }

    // Función para desactivar un usuario
    public function desactivar()
    {
        $user = new User();
        $id = isset($_POST["id"]) ? limpiarCadena($_POST["id"]) : "";
        $rspta = $user->desactivar($id);
        echo $rspta ? "Usuario desactivado correctamente" : "No se pudo desactivar el usuario";
    }

    // Función para listar todas las empresas (para los selects)
    public function listarEmpresas()
    {
        $user = new User();
        $rspta = $user->listarEmpresas();
        echo json_encode($rspta->fetch_all(MYSQLI_ASSOC));
    }

    // Función para listar todos los puestos de trabajo activos (para el select)
    public function listarPuestosActivos()
    {
        $jobPositions = new JobPositions();
        $rspta = $jobPositions->listarPuestosActivos();
        echo json_encode($rspta->fetch_all(MYSQLI_ASSOC));
    }

    // Función para obtener el historial de accesos de un usuario
    // Función para obtener el historial de accesos de un usuario
    public function obtenerHistorialAcceso()
    {
        $userId = isset($_POST['userId']) ? limpiarCadena($_POST['userId']) : "";

        $user = new User();
        $history = $user->obtenerHistorialAcceso($userId);

        if ($history) {
            echo json_encode(['success' => true, 'history' => $history->fetch_all(MYSQLI_ASSOC)]);
        } else {
            echo json_encode(['success' => false]);
        }
        exit();
    }

    // Función para cambiar la contraseña de un usuario
    public function cambiarPassword()
    {
        $user = new User();

        $id = isset($_POST["id"]) ? limpiarCadena($_POST["id"]) : "";
        $newPassword = isset($_POST["newPassword"]) ? limpiarCadena($_POST["newPassword"]) : "";

        $rspta = $user->cambiarPassword($id, $newPassword);
        echo $rspta ? "Contraseña actualizada correctamente" : "No se pudo actualizar la contraseña";
    }
}

//el toastify dice actualizado, pero no actualiza en la base de datos
if (isset($_GET["op"])) {
    $controller = new UserController();
    switch ($_GET["op"]) {
        case 'listar':
            $controller->listar();
            break;
        // Resto de los casos
        case 'insertar':
            $controller->insertar();
            break;
        case 'actualizar':
            $controller->actualizar();
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
        case 'cambiarPassword':
            $controller->cambiarPassword();
            break;
        case 'obtenerHistorialAcceso':
            $controller->obtenerHistorialAcceso();
            break;
    }
}
