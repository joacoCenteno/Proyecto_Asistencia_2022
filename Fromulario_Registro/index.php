<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ApiPHP</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Silkscreen&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

    <nav class="nav">
        <div class="logo">
            <img src="https://www.epet5-santamaria.edu.ar/img/logoConstrucion.png" class="logo-img" alt="">
            <h4 class="logo-text">E.P.E.T. N°5</h4> 
        </div>
    
        <div class="nav-links">
            <ul class="links">
                <li class="ul-item">
                    <a href="#" class="li-item">Inicio</a> 
                </li>
                <li class="ul-item">
                <a href="#" class="li-item">Nuestra Escuela</a> 
                </li>
                <li class="ul-item">
                <a href="#" class="li-item">Contacto</a> 
                </li>
            </ul>
        </div>   
        
    </nav>
    
    <section class="formulario">
        <form action="" method="post">
         <h1>Registro de Alumnos</h1>
         
        <input type="text" name="ntarjeta" maxlength="8" placeholder="Ingrese numero de tarjeta"> <br>
         <input type="text" name="legajo" maxlength="4" placeholder="Ingrese Legajo"><br>
            <input type="text" name="apellido" placeholder="Ingrese Apellido"> <br>
          <input type="text" name="nombre" placeholder="Ingrese Nombre"> <br>
          <input type="text" name="cuil" maxlength="11" placeholder="Ingrese CUIL"><br>
          <input type="number" min="1" name="id_curso" placeholder="ID de Curso"> <br>
          <input type="number" min="1" name="id_modalidad" placeholder="ID de Modalidad"> <br>
          <input type="email" name="email" placeholder="Ingrese Email"> <br>
          <input type="text" name="lug_nac" placeholder="Ingrese Lugar de Nacimiento"> <br>
           <label >Ingrese Fecha de Nacimiento <br> <input type="date" name="fech_nac" placeholder="Ingrese Fecha de Nacimiento"></label>  <br>
          <input type="text" name="domicilio" placeholder="Ingrese Domicilio"> <br>
          <input type="text" name="ref_domicilio" placeholder="Ingrese Referencia del Domicilio"> <br>
         <label for="" class="label local">Localidad 
            <select name="localidad" id="lista">
                <option value=""></option>
            </select>
         </label> <br>
         <input type="text" maxlength="10" name="tel_movil" placeholder="Ingrese Número de Teléfono Móvil"> <br>
          <input type="text" maxlength="6" name="tel_fijo" placeholder="Ingrese Número de Teléfono Fijo"> <br>
         <label for="" class="label">Beca <br>
            <input type="radio" name="beca" value="true"> Si
            <input type="radio" name="beca" value="false"> No
         </label> <br>
         <label for="" class="label">Pueblo Originario <br>
            <input id="radio_comunidad" type="radio" name="pueblo" value="true"> Si
            <input id="radio_comunidad_false" type="radio" name="pueblo" value="false"> No
         </label>
         <label> <p>Nombre de Comunidad Origniaria </p> <input id="comunidad_input" type="text" disabled="disabled" placeholder="Ingrese Nombre de Comunidad Origniaria" name="nom_comunidad" id="nom_comunidad"> <br>
         <label for="" class="label">Asiste caj <br>
            <input type="radio" name="asiste_caj" value="true"> Si
            <input type="radio" name="asiste_caj" value="false"> No
         </label> <br>
         <label for="" class="label">Programa de Transporte <br>
            <input type="radio" name="transporte" value="true"> Si
            <input type="radio" name="transporte" value="false"> No
         </label> 
          <input type="text" name="discapacidad" placeholder="Describa Discapacidad que posea"> <br>
         <label for="" class="label">Hermanos <br>
            <input type="radio" name="hermanos" value="true"> Si
            <input type="radio" name="hermanos" value="false"> No
         </label>
         <input type="submit" name="registro">
         <?php
            include("registrar.php");
         ?>
        </form>
   </section>
   
   
    
   <script src="js/main.js"></script>
    
</body>
</html>