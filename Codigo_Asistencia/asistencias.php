<?php
include "con_db.php"; //Incluimos el archivo con_db.php y con el la variable $con

date_default_timezone_set('America/Argentina/Catamarca'); //Estabecemos zona horaria
$fechaUS = date("Y-m-d"); //Convertimos la fecha actual a formato US para evitar errores en la BD
$fechaAR = date("d-m-Y"); //Convertimos la fecha actual en formato Argentina para enviarla por el SMS
$hora = date("H:i:s"); //Capturamos el horario actual



if($con){

    //echo "Conexion con la base de datos exitosa! ";

    if(isset($_POST['idTargeta'])){
        $numTargeta = $_POST['idTargeta'];
        $numTargetaFinal = substr($numTargeta, 1, 8);
        $lugar = substr($numTargeta, 0 , 1);

        $firstsql = "SELECT * FROM aux_asistencia WHERE n_targeta='$numTargetaFinal';";
        $firstresult = mysqli_query($con,$firstsql);

        if(mysqli_num_rows($firstresult) > 0){
                //echo "Ya registró su asistencia";
                $secondsql = "INSERT INTO asistencia(targeta,fecha,hora,entrada_salida,estado,creacion,actualizacion,lugar) VALUES('$numTargetaFinal','$fechaUS','$hora',false,true,'$fechaUS',default,'$lugar');";
                $secondresult = mysqli_query($con,$secondsql);
                $eliminarsql = "DELETE FROM aux_asistencia WHERE n_targeta = '$numTargetaFinal';";
                $eliminarresult = mysqli_query($con,$eliminarsql);

        }else{
            $secondsql = "INSERT INTO asistencia(targeta,fecha,hora,entrada_salida,estado,creacion,actualizacion,lugar) VALUES('$numTargetaFinal','$fechaUS','$hora',true,true,'$fechaUS',default,'$lugar');";
            $secondresult = mysqli_query($con,$secondsql);
            
            $auxsql= "INSERT INTO aux_asistencia(id_aux,n_targeta) VALUES (default,'$numTargetaFinal');";
            $auxresult = mysqli_query($con,$auxsql);

            if($secondresult && $auxresult){
                echo "Se guardo la asistencia en la BD";

            }else{
                echo "Error al registrar asistencia";
            }
        }

    }else{
        echo "No se registró la asistencia";
    }

}else{
    echo "No se pudo establecer la conexión con la BD";
}

?>


