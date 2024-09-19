<?php
require_once "global.php";

$conexion = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);

mysqli_query($conexion, 'SET NAMES "' . DB_ENCODE . '"');

//muestra posible error en la conexion
if (mysqli_connect_errno()) {
    printf("Falló en la conexion con la base de datos: %s\n", mysqli_connect_error());
    exit();
}

if (!function_exists('ejecutarConsulta')) {
    


    function ejecutarConsulta($sql, $params = [])
    {
        global $conexion;
        
        // Preparar la consulta
        $stmt = $conexion->prepare($sql);
        if ($stmt === false) {
            echo "Error en la preparación de la consulta: " . $conexion->error;
            return false;
        }
        
        // Vincular los parámetros si existen
        if (!empty($params)) {
            $types = str_repeat('s', count($params)); // Modificar según los tipos de los parámetros
            $stmt->bind_param($types, ...$params);  // Desempaquetar el array de parámetros
        }
    
        // Ejecutar la consulta
        if ($stmt->execute()) {
            // Para `SELECT`, devolver el resultado
            if (strpos($sql, 'SELECT') === 0) {
                return $stmt->get_result();
            }
            return true; // Para `UPDATE`, `DELETE` o `INSERT`, solo devolver éxito
        } else {
            echo "Error en la consulta: " . $stmt->error;
            return false;
        }
    }
    
    
    function ejecutarConsultaSimpleFila($sql)
    {
        global $conexion;
        $query = $conexion->query($sql);
        $row = $query->fetch_assoc();
        return $row;
    }
    function ejecutarConsulta_retornarID($sql)
    {
        global $conexion;
        $query = $conexion->query($sql);
        return $conexion->insert_id;
    }

    function limpiarCadena($str)
    {
        global $conexion;
        $str = mysqli_real_escape_string($conexion, trim($str));
        return htmlspecialchars($str);
    }

    function ejecutarConsultaArray($sql)
{
    global $conexion;
    $query = $conexion->query($sql);
    
    // Verifica si la consulta fue exitosa
    if (!$query) {
        echo "Error en la consulta: " . $conexion->error;
        return false;
    }
    
    // Crea un arreglo para almacenar los resultados
    $resultArray = array();
    
    // Itera sobre cada fila del resultado y la agrega al arreglo
    while ($row = $query->fetch_assoc()) {
        $resultArray[] = $row;
    }
    
    // Retorna el arreglo con todas las filas
    return $resultArray;
}

}
