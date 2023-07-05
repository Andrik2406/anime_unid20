<?php
class modules extends mysqli{
    public function __construct($host, $usuario, $pass, $bd){
        parent::__construct($host, $usuario, $pass, $bd);
    }

    public function get_data(){
        $consulta = "SELECT u.nombre, u.correo, u.passwords, ur.rol, rsc.status FROM usuarios u LEFT JOIN rel_rol ur ON u.rol = ur.id LEFT JOIN rel_status rsc ON u.status = rsc.id";
        $result = mysqli::query($consulta);
        $array = [];
        while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
            $array[]=[ 
                "nombre" => $row["nombre"],
                "rol" => $row["rol"],
                "status" => $row["status"],
                "correo" => $row["correo"],
                "passwords" => $row["passwords"],
            ];
        }
        echo json_encode($array);
    }
    
    public function insert_data(){
        mysqli_report(MYSQLI_REPORT_OFF);
        $nombre = $_POST['nombre'];
        $correo = $_POST['correo'];
        $passwords = $_POST['passwords'];
        $rol = $_POST['rol'];
        $status = $_POST['status'];
        

        $consulta_existencia = "SELECT correo FROM usuarios WHERE correo = '$correo'";
        $resultado_existencia = mysqli::query($consulta_existencia);
        if ($resultado_existencia->num_rows > 0) {
            $array = [
                "status" => "error",
                "text" => "El correo ya existe en la base de datos"
            ];
            echo json_encode($array);
            return;
        }
         
        $consulta = "INSERT INTO usuarios (correo, passwords, rol, status, nombre) VALUES ('$correo', '$passwords', '$rol', '$status', '$nombre')";
        $array = [
            "status" => "success",
            "text" => "Se insertó correctamente"
        ];
        
        if (!mysqli::query($consulta)) {
            $array = [
                "status" => "error",
                "text" => "No se pudo insertar el registro"
            ];
        }
        echo json_encode($array);
    }
}

$modules = new modules("localhost", "root", "", "anime_rocket");

if (isset($_POST)) {
    switch ($_POST["funcion"]) {
        case 'get_data':
            $modules->get_data();
            break;
        case 'insert_data':
            $modules->insert_data();
            break;
        default:
            echo "Función incompleta";
            break;
    }
}
?>

    
        
        
        
        