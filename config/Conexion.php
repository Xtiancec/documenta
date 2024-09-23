<?php
// Conexion.php

require_once "global.php";

$conexion = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);

mysqli_query($conexion, 'SET NAMES "' . DB_ENCODE . '"');

// Muestra posible error en la conexión
if (mysqli_connect_errno()) {
    printf("Falló en la conexión con la base de datos: %s\n", mysqli_connect_error());
    exit();
}

if (!function_exists('ejecutarConsulta')) {

    /**
     * Ejecuta una consulta SQL con parámetros y devuelve el resultado.
     *
     * @param string $sql La consulta SQL con placeholders (?).
     * @param array $params Los parámetros para reemplazar los placeholders.
     * @return mixed El resultado de la consulta o false en caso de error.
     */
    function ejecutarConsulta($sql, $params = [])
    {
        global $conexion;
        
        // Preparar la consulta
        $stmt = $conexion->prepare($sql);
        if ($stmt === false) {
            error_log("Error en la preparación de la consulta: " . $conexion->error);
            return false;
        }
        
        // Vincular los parámetros si existen
        if (!empty($params)) {
            $types = '';
            foreach ($params as $param) {
                if (is_int($param)) {
                    $types .= 'i';
                } elseif (is_double($param)) {
                    $types .= 'd';
                } else {
                    $types .= 's';
                }
            }
            $stmt->bind_param($types, ...$params);  // Desempaquetar el array de parámetros
        }
    
        // Ejecutar la consulta
        if ($stmt->execute()) {
            // Para `SELECT`, devolver el resultado
            if (stripos(trim($sql), 'SELECT') === 0) {
                return $stmt->get_result();
            }
            return true; // Para `UPDATE`, `DELETE` o `INSERT`, solo devolver éxito
        } else {
            error_log("Error en la ejecución de la consulta: " . $stmt->error);
            return false;
        }
    }
    
    /**
     * Ejecuta una consulta SQL que devuelve una sola fila.
     *
     * @param string $sql La consulta SQL con placeholders (?).
     * @param array $params Los parámetros para reemplazar los placeholders.
     * @return mixed Un array asociativo con la fila o false en caso de error.
     */
    function ejecutarConsultaSimpleFila($sql, $params = [])
    {
        $result = ejecutarConsulta($sql, $params);
        if ($result === false) {
            return false;
        }
        
        return $result->fetch_assoc();
    }

    /**
     * Ejecuta una consulta SQL y retorna el ID insertado.
     *
     * @param string $sql La consulta SQL con placeholders (?).
     * @param array $params Los parámetros para reemplazar los placeholders.
     * @return mixed El ID insertado o false en caso de error.
     */
    function ejecutarConsulta_retornarID($sql, $params = [])
    {
        global $conexion;
        $result = ejecutarConsulta($sql, $params);
        if ($result) {
            return $conexion->insert_id;
        }
        return false;
    }

    /**
     * Limpia una cadena para prevenir inyecciones SQL y ataques XSS.
     *
     * @param string $str La cadena a limpiar.
     * @return string La cadena limpia.
     */
    function limpiarCadena($str)
    {
        global $conexion;
        $str = mysqli_real_escape_string($conexion, trim($str));
        return htmlspecialchars($str);
    }

    /**
     * Ejecuta una consulta SQL que devuelve múltiples filas como un array.
     *
     * @param string $sql La consulta SQL con placeholders (?).
     * @param array $params Los parámetros para reemplazar los placeholders.
     * @return mixed Un array de arrays asociativos con las filas o false en caso de error.
     */
    function ejecutarConsultaArray($sql, $params = [])
    {
        $result = ejecutarConsulta($sql, $params);
        if ($result === false) {
            return false;
        }
        
        $resultArray = array();
        while ($row = $result->fetch_assoc()) {
            $resultArray[] = $row;
        }
        return $resultArray;
    }
}
?>
