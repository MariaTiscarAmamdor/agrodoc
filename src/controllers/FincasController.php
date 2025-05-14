<?php
include_once(__DIR__ . '/../models/basededatos.php');

class FincasController
{
    private $db;

    public function __construct()
    {
        $this->db = new basededatos();
    }
    public function getFincas()
    {
        $sql = "SELECT f.*, 
                   c.nombre AS nombre_contratista                  
            FROM fincas f
            LEFT JOIN contratistas c ON f.id_cont = c.id_cont
            ORDER BY f.id_finca ASC";

        $resultado = $this->db->ejecutarConsulta($sql);

        if ($resultado) {
            $datos = $resultado->fetchAll(PDO::FETCH_ASSOC);

            // Si se llama mediante AJAX, devolvemos JSON
            if (!empty($_GET['action']) && $_GET['action'] === 'listarFincas') {
                echo json_encode($datos);
                exit;
            }

            // Si se llama desde PHP directamente, devolvemos el array
            return $datos;
        } else {
            if (!empty($_GET['action']) && $_GET['action'] === 'listarFincas') {
                echo json_encode([]);
                exit;
            }
            return [];
        }
    }

    public function delFinca($id)
    {

        try {
            $sql = "DELETE FROM fincas WHERE id_finca = ?";
            $stmt = $this->db->conn->prepare($sql);
            $stmt->execute([$id]);

            if ($stmt->rowCount() > 0) {
                echo json_encode(["mensaje" => "Finca eliminada correctamente."]);
            } else {
                echo json_encode(["error" => "No se encontró la finca para eliminar."]);
            }
        } catch (PDOException $e) {
            echo json_encode(["error" => $e->getMessage()]);
        }
    }

    public function updateFinca($datosSerializados)
    {
        try {
            $datos = json_decode($datosSerializados, true);

            $sql = "UPDATE fincas
                SET cultivo = ?, hectarea = ?, localizacion = ?
                WHERE id_finca = ?";

            $stmt = $this->db->conn->prepare($sql);
            $stmt->execute([
                $datos[1],
                $datos[2],
                $datos[3],
                $datos[0]
            ]);

            if ($stmt->rowCount() > 0) {
                echo json_encode(["mensaje" => "Finca actualizada correctamente."]);
            } else {
                echo json_encode(["error" => "No se encontró la finca o los datos son los mismos."]);
            }
        } catch (PDOException $e) {
            echo json_encode(["error" => $e->getMessage()]);
        }
    }

    //Método para crear una finca y como no devuelve nada no usa ningun fetch
    public function setFinca($datos)
    {
        $datos = unserialize($datos);
        $this->db->conn->beginTransaction();
        $sql = "INSERT INTO fincas VALUES (?,?,?,?,?);";
        $stmt = $this->db->conn->prepare($sql);
        $stmt->execute(array(0, $datos[0], $datos[1], $datos[2], $datos[3]));
        $this->db->conn->commit();
    }

    //fincas asociadas a un contratista
    public function getFincasPorContratista($id_cont)
    {
        try {
            $sql = "SELECT f.*, 
                   c.nombre AS nombre_contratista                  
            FROM fincas f
            LEFT JOIN contratistas c ON f.id_cont = c.id_cont
            WHERE f.id_cont = ?";

            $stmt = $this->db->conn->prepare($sql);
            $stmt->execute([$id_cont]);
            $fincas = $stmt->fetchAll(PDO::FETCH_ASSOC);

            //Si se llama por AJAX, devuelve JSON
            if (!empty($_GET['action']) && $_GET['action'] === 'listarFincasPorContratista') {
                header('Content-Type: application/json');
                echo json_encode($fincas);
                exit;
            }

            //Si se llama desde PHP, simplemente retorna
            return $fincas;
        } catch (PDOException $e) {
            if (!empty($_GET['action'])) {
                header('Content-Type: application/json');
                echo json_encode(["error" => $e->getMessage()]);
                exit;
            } else {
                return [];
            }
        }
    }
    public function getFincasPorProveedor($idProveedor)
    {
        $sql = "
        SELECT f.id_finca, f.localizacion, f.hectarea, f.cultivo
        FROM fincas f
        INNER JOIN proyectos p ON p.id_finca = f.id_finca
        WHERE p.id_prov = ?
    ";

        $stmt = $this->db->conn->prepare($sql);
        $stmt->execute([$idProveedor]);
        $fincas = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Si se llama por AJAX
        if (!empty($_GET['action']) && $_GET['action'] === 'listarFincasPorProveedor') {
            header('Content-Type: application/json');
            echo json_encode($fincas);
            exit;
        }

        return $fincas;
    }
}

if (isset($_GET['action'])) {
    $controller = new FincasController();

    switch ($_GET['action']) {
        case 'listarFincas':
            $controller->getFincas();
            break;
        case 'eliminarFinca':
            if (isset($_GET['id'])) {
                $controller->delFinca($_GET['id']);
            }
            break;
        case 'modificarFinca':
            if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_GET['action'] === 'modificarFinca') {
                header('Content-Type: application/json');

                $input = file_get_contents('php://input');
                $data = json_decode($input, true);

                if (isset($data['datos'])) {
                    $controller = new FincasController();
                    $controller->updateFinca(json_encode($data['datos']));
                } else {
                    echo json_encode(["error" => "No se recibieron datos válidos"]);
                }
            }
            break;
        case 'listarFincasPorContratista':
            if (isset($_GET['id_cont'])) {
                $controller->getFincasPorContratista($_GET['id_cont']);
            }
            break;
        case 'listarFincasPorProveedor':
            if (isset($_GET['id_prov'])) {
                $controller->getFincasPorProveedor($_GET['id_prov']);
            }
            break;


        default:
            header('Content-Type: application/json');
            echo json_encode(["error" => "Acción no válida"]);
            exit;
    }
}
