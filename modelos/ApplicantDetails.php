<?php
require "../config/Conexion.php";

class ApplicantDetails
{
    // Insertar datos personales del postulante
    public function insertar($applicant_id, $phone, $emergency_contact_phone, $gender, $birth_date, $marital_status, $children_count, $birthplace, $education_level)
    {
        $sql = "INSERT INTO applicants_details (applicant_id, phone, emergency_contact_phone, gender, birth_date, marital_status, children_count, birthplace, education_level) 
                VALUES ('$applicant_id', '$phone', '$emergency_contact_phone', '$gender', '$birth_date', '$marital_status', '$children_count', '$birthplace', '$education_level')";
        return ejecutarConsulta($sql);
    }

    // Actualizar datos personales del postulante
    public function actualizar($id, $phone, $emergency_contact_phone, $gender, $birth_date, $marital_status, $children_count, $birthplace, $education_level)
    {
        $sql = "UPDATE applicants_details 
                SET phone='$phone', emergency_contact_phone='$emergency_contact_phone', gender='$gender', birth_date='$birth_date', marital_status='$marital_status', children_count='$children_count', birthplace='$birthplace', education_level='$education_level' 
                WHERE id='$id'";
        return ejecutarConsulta($sql);
    }

    // Mostrar detalles personales de un postulante
    public function mostrar($applicant_id)
    {
        $sql = "SELECT * FROM applicants_details WHERE applicant_id='$applicant_id'";
        return ejecutarConsultaSimpleFila($sql);
    }
}
