<?php

$token = 'token';
$website = 'https://api.telegram.org/bot'.$token;


require 'vendor/autoload.php';
use skrtdev\NovaGram\Bot;
use skrtdev\Telegram\Message;


$Bot = new Bot($token);



$Bot->onTextMessage(function (Message $message) use ($Bot) {
    include "conexion.php";
    
    date_default_timezone_set('America/Argentina/Catamarca');
    $fecha = date("Y-m-d");
    
    $chat = $message->chat;
    $texto = $message->text;
    $legajo = substr($texto, 3, 6);
    

    $sql = "SELECT asistencia_alumnos.hora FROM asistencia_alumnos WHERE asistencia_alumnos.fecha='$fecha' AND asistencia_alumnos.legajo=$legajo;";
    $result = mysqli_query($con,$sql);
    
    if($result){
        if(mysqli_num_rows($result) > 0){
            while($mostrar=mysqli_fetch_array($result)){
                $chat->sendMessage("Hora: $mostrar[hora]", true);
            }
        }else{
            $chat->sendMessage("No se encontraron registros :(", true);
        }
    }else{
        $chat->sendMessage("Error :(", true);
    }
    
});



?>