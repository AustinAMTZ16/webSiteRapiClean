<?php
include_once 'app/config/Database.php';

class ProspectosModel
{
    private $conn;

    public function __construct()
    {
        $this->conn = (new Database())->conn;
    }

    // Método para registrar un nuevo prospecto 
    public function crearProspecto($data)
    {
        $query = "INSERT INTO tb_prospecto (
                    nombre,
                    apellidoPaterno,
                    apellidoMaterno,
                    telefono,
                    correo,
                    asunto,
                    mensaje,
                    dominioOrigen,
                    giroDominio,
                    categoriaProspecto,
                    fechaCreacion,
                    estadoSistema,
                    conversacion,
                    fechaNacimiento,
                    lugarNacimiento,
                    origenProspecto
                ) VALUES (
                    :nombre,
                    :apellidoPaterno,
                    :apellidoMaterno,
                    :telefono,
                    :correo,
                    :asunto,
                    :mensaje,
                    :dominioOrigen,
                    :giroDominio,
                    :categoriaProspecto,
                    NOW(),
                    :estadoSistema,
                    :conversacion,
                    :fechaNacimiento,
                    :lugarNacimiento,
                    :origenProspecto
                )";
        try {
            $stmt = $this->conn->prepare($query);

            // Asignar valores a los parámetros
            $stmt->bindParam(':nombre', $data['nombre']);
            $stmt->bindParam(':apellidoPaterno', $data['apellidoPaterno']);
            $stmt->bindParam(':apellidoMaterno', $data['apellidoMaterno']);
            $stmt->bindParam(':telefono', $data['telefono']);
            $stmt->bindParam(':correo', $data['correo']);
            $stmt->bindParam(':asunto', $data['asunto']);
            $stmt->bindParam(':mensaje', $data['mensaje']);

            // Valores que normalmente son generados por el sistema
            $dominioOrigen = 'rapicleanpuebla.com'; // Puedes usar lógica si tienes mapeo
            $giroDominio = 'Lavandería Ropa'; // Puedes usar lógica si tienes mapeo
            $categoriaProspecto = 'Prospecto';
            $estadoSistema = 'Activo';
            $conversacion = 'Bitácora de conversación';

            $stmt->bindParam(':dominioOrigen', $dominioOrigen);
            $stmt->bindParam(':giroDominio', $giroDominio);
            $stmt->bindParam(':categoriaProspecto', $categoriaProspecto);
            $stmt->bindParam(':estadoSistema', $estadoSistema);
            $stmt->bindParam(':conversacion', $conversacion);

            // Campos adicionales si vienen desde el formulario
            $stmt->bindParam(':fechaNacimiento', $data['fechaNacimiento']);
            $stmt->bindParam(':lugarNacimiento', $data['lugarNacimiento']);
            $stmt->bindParam(':origenProspecto', $data['origenProspecto']);

            if ($stmt->execute()) {
                return [
                    'status' => 'success',
                    'message' => 'Prospecto creado exitosamente.'
                ];
            } else {
                return [
                    'status' => 'error',
                    'message' => 'Error al crear el prospecto.'
                ];
            }
        } catch (PDOException $e) {
            return [
                'status' => 'error',
                'type' => 'exception',
                'message' => 'Excepción: ' . $e->getMessage()
            ];
        }
    }
}
