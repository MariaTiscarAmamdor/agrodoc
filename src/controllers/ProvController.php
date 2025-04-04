<?php
include_once(__DIR__ . '/../models/basededatos.php');

class ProvController
{
    private $db;

    public function __construct()
    {
        $this->db = new basededatos();
    }

    public function getProveedores()
    {
        $sql = "SELECT * FROM proveedores ORDER BY nombre ASC";
        $resultado = $this->db->ejecutarConsulta($sql);

        if ($resultado) {
            $datos = $resultado->fetchAll(PDO::FETCH_ASSOC);

            // Si se llama mediante AJAX, devolvemos JSON
            if (!empty($_GET['action']) && $_GET['action'] === 'listarProveedores') {
                echo json_encode($datos);
                exit;
            }

            // Si se llama desde PHP directamente, devolvemos el array
            return $datos;
        } else {
            if (!empty($_GET['action']) && $_GET['action'] === 'listarProveedores') {
                echo json_encode([]);
                exit;
            }
            return [];
        }
    }

    public function delProveedor($id)
    {

        try {
            $sql = "DELETE FROM proveedores WHERE id_prov= ?";
            $stmt = $this->db->conn->prepare($sql);
            $stmt->execute([$id]);

            if ($stmt->rowCount() > 0) {
                echo json_encode(["mensaje" => "Proveedor eliminado correctamente."]);
            } else {
                echo json_encode(["error" => "No se encontró el proveedor para eliminar."]);
            }
        } catch (PDOException $e) {
            echo json_encode(["error" => $e->getMessage()]);
        }
    }

    public function updateProveedor($datosSerializados)
    {
        try {
            $datos = json_decode($datosSerializados, true);

            $sql = "UPDATE proveedores 
                SET nombre = ?, apellidos = ?, cif = ?, email = ?, telefono = ?, direccion = ?
                WHERE id_prov = ?";

            $stmt = $this->db->conn->prepare($sql);
            $stmt->execute([$datos[1], $datos[2], $datos[3], $datos[4], $datos[5], $datos[6], $datos[0]]);
            if ($stmt->rowCount() > 0) {
                echo json_encode(["mensaje" => "Proveedor actualizado correctamente."]);
            } else {
                echo json_encode(["error" => "No se encontró el proveedor o los datos son los mismos."]);
            }
        } catch (PDOException $e) {
            echo json_encode(["error" => $e->getMessage()]);
        }
    }

    public function setProveedor($datos)
    {
        $datos = unserialize($datos);
        $this->db->conn->beginTransaction();
        $sql = "INSERT INTO proveedores VALUES (?,?,?,?,?,?,?);";
        $stmt = $this->db->conn->prepare($sql);
        $stmt->execute(array(0, $datos[0], $datos[1], $datos[2], $datos[3], $datos[4], $datos[5]));
        $this->db->conn->commit();
    }
    public function getProveedoresPorContratista($idContratista)
    {


    $sql = "
        SELECT DISTINCT p.*
        FROM proveedores p
        INNER JOIN proyectos pr ON pr.id_prov = p.id_prov
        WHERE pr.id_cont = ?
    ";

    $stmt = $this->db->conn->prepare($sql);
    $stmt->execute([$idContratista]);

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

}


if (isset($_GET['action'])) {
    $controller = new ProvController();

    switch ($_GET['action']) {
        case 'listarProveedores':
            $controller->getProveedores();
            break;

        case 'eliminarProveedor':
            if (isset($_GET['id'])) {
                $controller->delProveedor($_GET['id']);
            }
            break;

        case 'modificarProveedor':
            if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_GET['action'] === 'modificarProveedor') {
                header('Content-Type: application/json');

                $input = file_get_contents('php://input');
                $data = json_decode($input, true);

                if (isset($data['datos'])) {
                    $controller = new ProvController();
                    $controller->updateProveedor(json_encode($data['datos']));
                } else {
                    echo json_encode(["error" => "No se recibieron datos válidos"]);
                }
            }
            break;

        case 'crearProveedor':
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $controller->setProveedor($_POST);
            }
            break;

        default:
            header('Content-Type: application/json');
            echo json_encode(["error" => "Acción no válida"]);
            exit;
    }
}
