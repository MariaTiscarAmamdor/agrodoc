<?php
include_once(__DIR__ . '/../models/basededatos.php');

class ContController
{
    private $db;

    public function __construct()
    {
        $this->db = new basededatos();
    }

    public function getContratistas()
    {
        $sql = "SELECT * FROM contratistas ORDER BY id_cont ASC";
        $resultado = $this->db->ejecutarConsulta($sql);

        if ($resultado) {
            $datos = $resultado->fetchAll(PDO::FETCH_ASSOC);

            // Si se llama mediante AJAX, devolvemos JSON
            if (!empty($_GET['action']) && $_GET['action'] === 'listarContratistas') {
                echo json_encode($datos);
                exit;
            }

            // Si se llama desde PHP directamente, devolvemos el array
            return $datos;
        } else {
            if (!empty($_GET['action']) && $_GET['action'] === 'listarContratistas') {
                echo json_encode([]);
                exit;
            }
            return [];
        }
    }

    public function delContratista($id)
    {

        try {
            $sql = "DELETE FROM contratistas WHERE id_cont= ?";
            $stmt = $this->db->conn->prepare($sql);
            $stmt->execute([$id]);

            if ($stmt->rowCount() > 0) {
                echo json_encode(["mensaje" => "Contratista eliminado correctamente."]);
            } else {
                echo json_encode(["error" => "No se encontró el contratista para eliminar."]);
            }
        } catch (PDOException $e) {
            echo json_encode(["error" => $e->getMessage()]);
        }
    }

    public function updateContratista($datosSerializados)
    {
        try {
            $datos = json_decode($datosSerializados, true);

            $sql = "UPDATE contratistas 
                SET nombre = ?,  cif = ?, email = ?, telefono = ?, direccion = ?
                WHERE id_cont = ?";

            $stmt = $this->db->conn->prepare($sql);
            $stmt->execute([$datos[1], $datos[2], $datos[3], $datos[4], $datos[5], $datos[0] ]); 
            

            if ($stmt->rowCount() > 0) {
                echo json_encode(["mensaje" => "Contratista actualizado correctamente."]);
            } else {
                echo json_encode(["error" => "No se encontró el contratista o los datos son los mismos."]);
            }
        } catch (PDOException $e) {
            echo json_encode(["error" => $e->getMessage()]);
        }
    }

        //Método para crear un contratista y como no devuelve nada no usa ningun fetch
        public function setContratista($datos)
        {
            $datos = unserialize($datos);
            $this->db->conn->beginTransaction();
            $sql = "INSERT INTO contratistas VALUES (?,?,?,?,?,?);";
            $stmt = $this->db->conn->prepare($sql);
            $stmt->execute(array(0, $datos[0], $datos[1], $datos[2], $datos[3], $datos[4]));
            $this->db->conn->commit();
        }
}


if (isset($_GET['action'])) {
    $controller = new ContController();

    switch ($_GET['action']) {
        case 'listarContratistas':
            $controller->getContratistas();
            break;

        case 'eliminarContratista':
            if (isset($_GET['id'])) {
                $controller->delContratista($_GET['id']);
            }
            break;

        case 'modificarContratista':
            if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_GET['action'] === 'modificarContratista') {
                header('Content-Type: application/json');

                $input = file_get_contents('php://input');
                $data = json_decode($input, true);

                if (isset($data['datos'])) {
                    $controller = new ContController();
                    $controller->updateContratista(json_encode($data['datos']));
                } else {
                    echo json_encode(["error" => "No se recibieron datos válidos"]);
                }
            }
            break;

        case 'crearContratista':
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $controller->setContratista($_POST);
            }
            break;

        default:
            header('Content-Type: application/json');
            echo json_encode(["error" => "Acción no válida"]);
            exit;
    }
}
