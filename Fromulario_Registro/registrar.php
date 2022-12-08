<?php


include "con_db.php";


function buscarRepetido($cuil){
    include "con_db.php";
    $sql = "SELECT dni FROM datos_alumnos WHERE dni='$cuil'";
    $result = mysqli_query($con,$sql);

    if(mysqli_num_rows($result) > 0){ 
        return 1;
    }else{
        return 0;
    }
}

if(isset($_POST['registro'])){

    if(strlen($_POST['ntarjeta']) >= 1
     && strlen($_POST['legajo']) >= 1
     && strlen($_POST['apellido']) >= 1 
     && strlen($_POST['nombre']) >= 1
     && strlen($_POST['cuil']) >= 1 
     && strlen($_POST['id_curso']) >= 1 
     && strlen($_POST['id_modalidad']) >= 1 
     && strlen($_POST['email']) >= 1
     && strlen($_POST['lug_nac']) >= 1 
     && strlen($_POST['domicilio']) >= 1 
     && strlen($_POST['ref_domicilio']) >= 1 
     && strlen($_POST['tel_movil']) >= 1
     && strlen($_POST['tel_fijo']) >= 1 
     && strlen($_POST['discapacidad']) >= 1 
    ){

        $tarjeta = trim($_POST['ntarjeta']);
        $legajo = trim($_POST['legajo']);
        $apellido = trim($_POST['apellido']);
        $nombre = trim($_POST['nombre']);
        $cuil = trim($_POST['cuil']);
        $id_curso = trim($_POST['id_curso']);
        $id_modalidad = trim($_POST['id_modalidad']);
        $email = trim($_POST['email']);
        $lug_nac = trim($_POST['lug_nac']);
        $fecha_nac = trim($_POST['fech_nac']);
        $domicilio = trim($_POST['domicilio']);
        $ref_domicilio = trim($_POST['ref_domicilio']);
        $localidad = $_POST['localidad'];
        $tel_movil = '+54'.trim($_POST['tel_movil']);
        $tel_fijo = trim($_POST['tel_fijo']);
        if($_POST['beca'] === "true"){$beca = true;} else{$beca = false;}
        if($_POST['pueblo'] === "true"){ $pueblo = true;} else{$pueblo = false;}
        $nom_comunidad = trim($_POST['nom_comunidad']);
        if($_POST['asiste_caj'] === "true"){ $asiste_caj = true;} else{$asiste_caj = false;}
        if($_POST['transporte'] === 'true'){ $transporte = true;} else{$transporte = false;}
        $discapacidad = trim($_POST['discapacidad']);
        if($_POST['hermanos'] === 'true'){ $hermanos = true;} else{$hermanos = false;}

        if(buscarRepetido($cuil)==1){
            ?>
            <h3 class="bad">Usuario Ya Registrado!</h3>
            <?php
        }else{

                $consulta = "INSERT INTO datos_alumnos(`numero_tarjeta`, `legajo`, `apellido`, `nombre`, `dni`, `id_curso`, `id_modalidad`, `email`, `lugar_nac`, `fecha_nac`, `domicilio`, `ref_domicilio`, `localidad`, `tel_movil`, `tel_fijo`, `beca`, `pueblo_originiario`, `nombre_comunidad`, `asiste_caj`, `programa_transporte`, `discapacidad`, `hermanos`) VALUES ('$tarjeta','$legajo','$apellido','$nombre','$cuil','$id_curso','$id_modalidad','$email','$lug_nac','$fecha_nac','$domicilio','$ref_domicilio','$localidad','$tel_movil','$tel_fijo','$beca','$pueblo','$nom_comunidad','$asiste_caj','$transporte','$discapacidad','$hermanos')";

                $resultado = mysqli_query($con,$consulta);

                if($resultado){
                    ?>
                    <h3 class="ok">Enviado!</h3>
                    <?php
           
                }else{
                    ?>
                    <h3 class="bad">Error!</h3>
                    <?php
                 }

        }
    }else{
    ?>
    <h3 class="bad">Por favor complete los campos!</h3>
    <?php
    }

}

?>