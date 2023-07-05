<?php
// la clase admin para conectar a la base de datos

class Admin extends mysqli{
    public function __construct($host,$usuario,$pass,$bd){
        parent::__construct($host,$usuario,$pass,$bd);
    }
    
    public function validation($correo, $passwords){
        $consulta = "SELECT correo, passwords FROM usuarios WHERE correo='$correo' AND passwords='$passwords' AND status='1' ";
        $query = $this->query($consulta);
        return $query;
    }
}

// validation del usuario y contraseña en cuyo caso este mal lo va a redirigir al index de anime

    $validation= new Admin("localhost","root","","anime_rocket");
    $result = $validation->validation($_POST['correo'], $_POST['passwords']);
            if (mysqli_num_rows($result) > 0) {
                session_start();

                header("location: ../../admin/index.php");

            } else {

                header("location: ../../index.php");
            }
    
?>