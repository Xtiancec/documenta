<?php
require_once "../config/Conexion.php";

class Experience
{
    // Insertar experiencia educativa
    public function insertarEducacion($applicant_id, $institution, $education_type, $start_date, $end_date, $duration)
    {
        $sql = "INSERT INTO education_experience (applicant_id, institution, education_type, start_date, end_date, duration) 
                VALUES ('$applicant_id', '$institution', '$education_type', '$start_date', '$end_date', '$duration')";
        return ejecutarConsulta($sql);
    }

    // Insertar experiencia laboral
    public function insertarTrabajo($applicant_id, $company, $position, $start_date, $end_date)
    {
        $sql = "INSERT INTO work_experience (applicant_id, company, position, start_date, end_date) 
                VALUES ('$applicant_id', '$company', '$position', '$start_date', '$end_date')";
        return ejecutarConsulta($sql);
    }
    

    // Mostrar experiencia educativa
    public function mostrarEducation($applicant_id)
    {
        $sql = "SELECT * FROM education_experience WHERE applicant_id='$applicant_id'";
        return ejecutarConsultaArray($sql); // Devolver todas las filas
    }

    // Obtener las experiencias laborales por el ID del postulante
    public function mostrarWork($applicant_id)
    {
        $sql = "SELECT * FROM education_experience WHERE applicant_id='$applicant_id'";
        return ejecutarConsultaArray($sql); // Devolver todas las filas
    }

    // Editar experiencia educativa
    public function editarEducacion($id, $institution, $education_type, $start_date, $end_date, $duration)
    {
        $sql = "UPDATE education_experience 
                SET institution='$institution', education_type='$education_type', start_date='$start_date', end_date='$end_date', duration='$duration' 
                WHERE id='$id'";
        return ejecutarConsulta($sql);
    }

    // Editar experiencia laboral
    public function editarTrabajo($id, $company, $position, $start_date, $end_date)
    {
        $sql = "UPDATE work_experience 
                SET company='$company', position='$position', start_date='$start_date', end_date='$end_date' 
                WHERE id='$id'";
        return ejecutarConsulta($sql);
    }
}
?>
