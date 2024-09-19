<?php
session_start();
require_once "../modelos/Experience.php";

class ExperienceController
{

    // Mostrar experiencia educativa
    public function mostrarEducacion()
    {
        $applicant_id = $_SESSION['applicant_id'];
        $experience = new Experience();
        $result = $experience->mostrarEducation($applicant_id);

        if ($result) {
            echo json_encode($result); // Enviar datos como JSON
        } else {
            echo json_encode([]); // Enviar un array vacío si no hay resultados
        }
    }

    // Mostrar experiencia laboral
    public function mostrarTrabajo()
    {
        $applicant_id = $_SESSION['applicant_id'];
        $experience = new Experience();
        $result = $experience->mostrarWork($applicant_id);

        if ($result) {
            echo json_encode($result); // Enviar datos como JSON
        } else {
            echo json_encode([]); // Enviar un array vacío si no hay resultados
        }
    }

    // Guardar cambios en experiencia educativa y laboral
    public function guardarCambios()
    {
        $applicant_id = $_SESSION['applicant_id'];

        // Guardar experiencia educativa
        if (isset($_POST['institution'])) {
            $education_ids = $_POST['education_id'];
            $institutions = $_POST['institution'];
            $education_types = $_POST['education_type'];
            $start_dates = $_POST['start_date_education'];
            $end_dates = $_POST['end_date_education'];
            $durations = $_POST['duration_education'];

            $experience = new Experience();
            foreach ($education_ids as $key => $id) {
                $experience->editarEducacion($id, $institutions[$key], $education_types[$key], $start_dates[$key], $end_dates[$key], $durations[$key]);
            }
        }

        // Guardar experiencia laboral
        if (isset($_POST['company'])) {
            $work_ids = $_POST['work_id'];
            $companies = $_POST['company'];
            $positions = $_POST['position'];
            $start_dates = $_POST['start_date_work'];
            $end_dates = $_POST['end_date_work'];

            $experience = new Experience();
            foreach ($work_ids as $key => $id) {
                $experience->editarTrabajo($id, $companies[$key], $positions[$key], $start_dates[$key], $end_dates[$key]);
            }
        }

        echo json_encode(['status' => true, 'message' => 'Datos guardados correctamente']);
    }

    // Guardar experiencia educativa
    public function guardarEducacion()
    {
        $applicant_id = $_SESSION['applicant_id'];
        $institutions = $_POST['institution'];
        $education_types = $_POST['education_type'];
        $start_dates = $_POST['start_date_education'];
        $end_dates = $_POST['end_date_education'];
        $durations = $_POST['duration_education'];

        $experience = new Experience();
        foreach ($institutions as $key => $institution) {
            $result = $experience->insertarEducacion($applicant_id, $institution, $education_types[$key], $start_dates[$key], $end_dates[$key], $durations[$key]);
        }

        echo json_encode(['status' => $result ? true : false]);
    }

    // Guardar experiencia laboral
    public function guardarTrabajo()
    {
        $applicant_id = $_SESSION['applicant_id'];
        $companies = $_POST['company'];
        $positions = $_POST['position'];
        $start_dates = $_POST['start_date_work'];
        $end_dates = $_POST['end_date_work'];

        $experience = new Experience();
        foreach ($companies as $key => $company) {
            $result = $experience->insertarTrabajo($applicant_id, $company, $positions[$key], $start_dates[$key], $end_dates[$key]);
        }

        echo json_encode(['status' => $result ? true : false]);
    }
}

// Llamar a las funciones según el parámetro 'op'
if (isset($_GET['op'])) {
    $controller = new ExperienceController();
    switch ($_GET['op']) {
        case 'guardarEducacion':
            $controller->guardarEducacion();
            break;
        case 'guardarTrabajo':
            $controller->guardarTrabajo();
            break;
        case 'mostrarEducacion':
            $controller->mostrarEducacion();
            break;
        case 'mostrarTrabajo':
            $controller->mostrarTrabajo();
            break;
        case 'guardarCambios':
            $controller->guardarCambios();
            break;
    }
}
