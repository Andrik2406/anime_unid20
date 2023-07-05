<?php
    $validation= new Admin("localhost","root","","anime_rocket");
    $result = $validation->validation($_POST['correo'], $_POST['pass']);
            if (mysqli_num_rows($result) > 0) {
                session_start();
                header("location: ../admin/bien.php");
            } else {
                header("location: ../admin/index.php");
            }
    class Admin extends mysqli{
        public function __construct($host,$usuario,$pass,$bd){
            parent::__construct($host,$usuario,$pass,$bd);
        }
        
        public function validation($correo, $pass){
            $consulta = "SELECT correo, pass, rol FROM usuarios WHERE correo='$correo' AND pass='$pass' AND statuss='1' AND rol='1'";
            $query = $this->query($consulta);
            return $query;
        }
    }
?>