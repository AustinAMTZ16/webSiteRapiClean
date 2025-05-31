<?php
// Declarar como variables globales
// Incluir el controlador
include_once 'app/controllers/Prospectos/ProspectosController.php';

// Instanciamos el controlador
$controllerProspectos = new ProspectosController();

//Obtener el método de la solicitud HTTP
$requestMethod = $_SERVER['REQUEST_METHOD'];

// Configurar CORS
header("Access-Control-Allow-Origin: *"); // Permitir solicitudes desde cualquier origen
header("Access-Control-Allow-Methods: POST, GET, OPTIONS, PATCH, DELETE"); // Permitir métodos HTTP
header("Access-Control-Allow-Headers: Content-Type"); // Permitir ciertos encabezados

// TRY: CONTROLA LOS METODOS [GET-POST-PATCH-DALETE] Y EXCEPTION A ERROR 500
try {
    if (isset($_GET['action'])) {
        $action = $_GET['action'];
        $data = json_decode(file_get_contents("php://input"));
        // Ejecutar el manejo según el método de la solicitud HTTP
        switch ($requestMethod) {
            case 'GET':
                handleGetRequest($action, $data);
                break;
            case 'POST':
                handlePostRequest($action, $data);
                break;
            case 'PATCH':
                handlePatchRequest($action, $data);
                break;
            case 'DELETE':
                handleDeleteRequest($action, $data);
                break;
            default:
                http_response_code(404);
                echo json_encode([
                    'Message' => 'Solicitud no válida.'
                ], JSON_UNESCAPED_UNICODE);
                break;
        }
    } else {
        http_response_code(404);
        echo json_encode([
            'Message' => 'No hay acción. URL'
        ], JSON_UNESCAPED_UNICODE);
    }
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        'Message' => 'Error interno del servidor. Detalles: ' . $e->getMessage() . ' en línea ' . $e->getLine()
    ], JSON_UNESCAPED_UNICODE);
}
// Función para manejar las solicitudes POST
function handlePostRequest($action, $data)
{
    header('Content-Type: application/json; charset=utf-8');

    // Validar que existan datos
    if (empty($data)) {
        http_response_code(400); // Bad Request
        echo json_encode(['message' => 'Datos no proporcionados'], JSON_UNESCAPED_UNICODE);
        exit;
    }
    switch ($action) {
        case 'crearProspecto':
            // Usar el controlador como una dependencia (si aplica en tu estructura)
            global $controllerProspectos;
            // Asegurar que $data es un arreglo
            $controllerProspectos->crearProspecto((array) $data);
            if ($respuesta) {
                http_response_code(200);
                echo json_encode([
                    'message' => 'Trámite registrado.',
                    'data'    => $respuesta
                ], JSON_UNESCAPED_UNICODE);
            } else {
                http_response_code(500);
                echo json_encode([
                    'message' => 'Trámite no registrado. Intenta nuevamente.'
                ], JSON_UNESCAPED_UNICODE);
            }
            exit;
            break;
        default:
            http_response_code(404);
            echo json_encode(['Message' => 'Acción POST desconocida.'], JSON_UNESCAPED_UNICODE);
            exit;
            break;
    }
}

// Función para manejar las solicitudes GET
function handleGetRequest($action, $data)
{
    switch ($action) {
        case 'consult':
            // Declarar como global
            global $controllerOficios;
            $respuesta = $controllerOficios->listarRegistroOficios();
            if ($respuesta) {
                http_response_code(200);
                echo json_encode(array('message' => 'Listado de registros de oficios.', 'data' => $respuesta), JSON_UNESCAPED_UNICODE);
            } else {
                http_response_code(404);
                echo json_encode(array('message' => 'No se encontraron registros de oficios.'), JSON_UNESCAPED_UNICODE);
            }
            exit;
            break;

        default:
            http_response_code(404);
            echo json_encode(['Message' => 'Acción GET desconocida.'], JSON_UNESCAPED_UNICODE);
            exit;
            break;
    }
}
// Función para manejar las solicitudes PATCH
function handlePatchRequest($action, $data)
{
    switch ($action) {
        case 'update':
            if (!empty($data)) {
                global $controllerOficios;
                $respuesta = $controllerOficios->actualizarRegistroOficio((array) $data);
            } else {
                echo "Datos no proporcionados";
                exit;
            }
            if ($respuesta) {
                http_response_code(200);
                echo json_encode(array('message' => 'Registro de oficio modificado.', 'data' => $respuesta), JSON_UNESCAPED_UNICODE);
            } else {
                http_response_code(404);
                echo json_encode(array('message' => 'Registro de oficio no modificado.'), JSON_UNESCAPED_UNICODE);
            }
            exit;
            break;
        default:
            http_response_code(404);
            echo json_encode(['Message' => 'Acción PATCH desconocida.'], JSON_UNESCAPED_UNICODE);
            break;
    }
}
// Función para manejar las solicitudes DELETE
function handleDeleteRequest($action, $data)
{
    switch ($action) {
        case 'delete':
            header('Content-Type: application/json');

            try {
                // Para método DELETE, leemos el input directamente
                $input = json_decode(file_get_contents('php://input'), true);

                if (empty($input['ID_RegistroOficios'])) {
                    throw new Exception("ID no proporcionado");
                }

                global $controllerOficios;
                $resultado = $controllerOficios->eliminarRegistroOficio($input);

                // Solo codificamos a JSON una vez al final
                if ($resultado['success']) {
                    http_response_code(200);
                    echo json_encode($resultado, JSON_UNESCAPED_UNICODE);
                } else {
                    http_response_code(404);
                    echo json_encode($resultado, JSON_UNESCAPED_UNICODE);
                }
            } catch (Exception $e) {
                http_response_code(400);
                echo json_encode([
                    "success" => false,
                    "error" => $e->getMessage()
                ], JSON_UNESCAPED_UNICODE);
            }
            exit;
            break;
        default:
            http_response_code(404);
            echo json_encode(['Message' => 'Acción DELETE desconocida.'], JSON_UNESCAPED_UNICODE);
            break;
    }
}
