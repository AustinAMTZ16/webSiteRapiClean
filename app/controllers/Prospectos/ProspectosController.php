<?php
include_once 'app/models/Prospectos/ProspectosModel.php';

class ProspectosController {
    private $model;

    public function __construct() {
        $this->model = new ProspectosModel();
    } 

    // Instancia para crear un nuevo prospecto
    public function crearProspecto($data) {
       $result = $this->model->crearProspecto($data);

        // Encabezado de tipo JSON
        header('Content-Type: application/json; charset=utf-8');

        if ($result['status'] === 'success') {
            http_response_code(200); // OK
        } elseif (isset($result['type']) && $result['type'] === 'validation') {
            http_response_code(400); // Bad Request
        } else {
            http_response_code(500); // Internal Server Error
        }

        echo json_encode($result, JSON_UNESCAPED_UNICODE);
        exit;
    }
}   
?>