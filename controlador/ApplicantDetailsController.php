<?php
require_once "../modelos/ApplicantDetails.php";
session_start(); // Asegurarse de que la sesión esté iniciada

class ApplicantDetailsController
{
    public function guardar()
    {
        if (!isset($_SESSION['applicant_id'])) {
            echo json_encode(['status' => false, 'message' => 'Sesión no iniciada.']);
            return;
        }

        $applicant_id = $_SESSION['applicant_id'];
        $phone = isset($_POST["phone"]) ? limpiarCadena($_POST["phone"]) : "";
        $emergency_contact_phone = isset($_POST["emergency_contact_phone"]) ? limpiarCadena($_POST["emergency_contact_phone"]) : "";
        $gender = isset($_POST["gender"]) ? limpiarCadena($_POST["gender"]) : "";
        $birth_date = isset($_POST["birth_date"]) ? limpiarCadena($_POST["birth_date"]) : "";
        $marital_status = isset($_POST["marital_status"]) ? limpiarCadena($_POST["marital_status"]) : "";
        $children_count = isset($_POST["children_count"]) ? limpiarCadena($_POST["children_count"]) : "";
        $birthplace = isset($_POST["birthplace"]) ? limpiarCadena($_POST["birthplace"]) : "";
        $education_level = isset($_POST["education_level"]) ? limpiarCadena($_POST["education_level"]) : "";

        $applicantDetails = new ApplicantDetails();
        $result = $applicantDetails->insertar($applicant_id, $phone, $emergency_contact_phone, $gender, $birth_date, $marital_status, $children_count, $birthplace, $education_level);

        echo json_encode([
            'status' => $result ? true : false,
            'message' => $result ? "Datos guardados correctamente" : "Error al guardar los datos"
        ]);
    }

    public function actualizar()
    {
        if (!isset($_SESSION['applicant_id'])) {
            echo json_encode(['status' => false, 'message' => 'Sesión no iniciada.']);
            return;
        }

        $applicant_id = $_SESSION['applicant_id'];
        $phone = isset($_POST["phoneUpdate"]) ? limpiarCadena($_POST["phoneUpdate"]) : "";
        $emergency_contact_phone = isset($_POST["emergency_contact_phoneUpdate"]) ? limpiarCadena($_POST["emergency_contact_phoneUpdate"]) : "";
        $gender = isset($_POST["genderUpdate"]) ? limpiarCadena($_POST["genderUpdate"]) : "";
        $birth_date = isset($_POST["birth_dateUpdate"]) ? limpiarCadena($_POST["birth_dateUpdate"]) : "";
        $marital_status = isset($_POST["marital_statusUpdate"]) ? limpiarCadena($_POST["marital_statusUpdate"]) : "";
        $children_count = isset($_POST["children_countUpdate"]) ? limpiarCadena($_POST["children_countUpdate"]) : "";
        $birthplace = isset($_POST["birthplaceUpdate"]) ? limpiarCadena($_POST["birthplaceUpdate"]) : "";
        $education_level = isset($_POST["education_levelUpdate"]) ? limpiarCadena($_POST["education_levelUpdate"]) : "";

        $applicantDetails = new ApplicantDetails();
        $existingDetails = $applicantDetails->mostrar($applicant_id);

        if ($existingDetails) {
            $result = $applicantDetails->actualizar($existingDetails['id'], $phone, $emergency_contact_phone, $gender, $birth_date, $marital_status, $children_count, $birthplace, $education_level);
            echo json_encode([
                'status' => $result ? true : false,
                'message' => $result ? "Datos actualizados correctamente" : "Error al actualizar los datos"
            ]);
        } else {
            echo json_encode([
                'status' => false,
                'message' => "No se encontraron datos para actualizar"
            ]);
        }
    }

    public function mostrar()
    {
        if (!isset($_SESSION['applicant_id'])) {
            echo json_encode(['status' => false, 'message' => 'Sesión no iniciada.']);
            return;
        }

        $applicant_id = $_SESSION['applicant_id'];
        $applicantDetails = new ApplicantDetails();
        $result = $applicantDetails->mostrar($applicant_id);

        if ($result) {
            echo json_encode($result);
        } else {
            echo json_encode([
                'status' => false,
                'message' => "No se encontraron datos registrados"
            ]);
        }
    }
}

if (isset($_GET["op"])) {
    $controller = new ApplicantDetailsController();
    switch ($_GET["op"]) {
        case 'guardar':
            $controller->guardar();
            break;
        case 'actualizar':
            $controller->actualizar();
            break;
        case 'mostrar':
            $controller->mostrar();
            break;
    }
}
