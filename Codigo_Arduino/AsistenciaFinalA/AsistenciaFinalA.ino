#include <ESP8266HTTPClient.h>
#include <ESP8266WiFi.h>
#include <ESP8266WiFiMulti.h>
#include <WiFiClient.h>
#include <Wiegand.h>
#include <LiquidCrystal_I2C.h>
#include <Wire.h>

#include "RTClib.h"

LiquidCrystal_I2C lcd(0x27,20,4);

RTC_DS1307 rtc;

// Defino los pines a utilizar
#define WG_PIN_GREEN 12  // D6 pines modulo esp8266
#define WG_PIN_WHITE 13  // D7 pines modulo esp8266

// Defino el nombre de red y su contraseña
#define STASSID "nombre de red"
#define STAPSK "contraseña"

const char* ssid = STASSID;  // variable donde guardo el nombre del la red wifi
const char* password = STAPSK;  // variable donde guardo contraseña de la red wifi

const char* host = "192.168.1.1"; // puerta de enlace del router
const uint16_t port = 1000;

// Variable donde de Guarda el numero de targeta
String idTargeta;
//Variable auxiliar para guardar el n° de tarjeta
String auxTarjeta="";

// Declaramos los diferentes objetos
WIEGAND lectorTargeta;  // objeto para leer la targeta
WiFiClient client; // objeto para conectr con un host en la nube el servidor
ESP8266WiFiMulti conexionWifi; // Objeto para el manejo en la conexion de wifi

void setup() {
  lcd.init(); // Iniciando el lcd
  lcd.backlight(); // encendemos la luz de fondo
  lcd.print("Esperando Tarjeta"); //Mostrando mensaje de inicio
  
 

  if (! rtc.begin()) {
    Serial.println("No pudo encontrar RTC");
    Serial.flush();
    while (1) delay(10);
  }
  
   DateTime now = rtc.now(); //objeto rtc(para
    lcd.setCursor(12,3);
    lcd.print(now.hour(), DEC);//muestra la hora
    lcd.print(':');
    lcd.print(now.minute(), DEC);//muestra los minutos 
    lcd.print(':');
    lcd.print(now.second(), DEC);//muestra los segundos
  
  Serial.begin(115200);  // inicializo puerte serial solopara ver no es necesario
  Serial.println(); // imprimo un salto de lineas en el puerto serial
  Serial.println("Lector RFID Wiegand");  // mensaje por el puerto serial
  lectorTargeta.begin(WG_PIN_GREEN,WG_PIN_WHITE); // Inicializo el objeto que realizara la lectura de la targeta le mando dos parametros que son los puertos D6 y D7

  Serial.println("Conexion a la Red Wifi"); // mensaje por el puerto serial
  WiFi.mode(WIFI_STA); // inicializo el objeto que maneja la conexion wifi
  conexionWifi.addAP(ssid,password); // le paso al objeto  que maneja la copnexion wifi el nomnbre de red y la contraseña
  Serial.println(""); // imprime salto de linea en el puerto serial
  Serial.println(""); // imprime salto de linea en el puerto serial
  Serial.print("Esperando Red WiFi..."); // solo e sun mensaje de espera 

  while(conexionWifi.run() != WL_CONNECTED) // abre la conexion unaves que se conecta sale del while
  {
    lcd.setCursor(0,1);  //colocamos el cursor en fila 0 y columna 1
    lcd.print("Esperando WiFi");
   }
   Serial.println("");   //  si sale del while es porque se conecto al router
   Serial.println("Conectado al WiFi");
   Serial.print("Mi dirección IP es: ");
   Serial.println(WiFi.localIP()); // imprimo la direccion ip que le asigna el router al modulo arduino
   Serial.println("Conexión iniciada correctamente");
   delay(500);

   
}


void loop(){
if(conexionWifi.run() != WL_CONNECTED || WiFi.status() != WL_CONNECTED){
    lcd.setCursor(0,1);  //colocamos el cursor en fila 0 y columna 1
    lcd.clear(); //se limpia la pantalla
    lcd.print("Sin conexion WiFi"); //Mostrando mensaje de inicio
  }
  
DateTime now = rtc.now(); //objeto rtc(para

if(now.second()==10){auxTarjeta="";}
   
if(LeerTarjeta()) // verifico si hay targeta en el lector la funcion LeerTargeta devuelve un true/false
 {
  Serial.println(LeerTarjeta()); // si hay targeta o hay lectura llamo a la funcion LeerTargeta que devuelve un true/false (es solo para chekear)
  if(auxTarjeta != idTargeta){ //verifico que el n° de tarjeta ingresado no sea igual al auxiliar
      auxTarjeta = idTargeta; //en caso de cumplirse le asigno el valor de lal tarjeta en la variable auxiliar
      Serial.print("Targeta Nº: "); /// messaje por el puerto serial
      Serial.println(idTargeta); // muestro el numero de targeta que esta guardad en la variable global idTargeta (es el tipo string)
      EnviarDatos();  // llamo a la funcion EnviarDatos() esta funcion envia los datos al servidor
      
  }else{
    lcd.print("Tarjeta Repetida");  //Muestra por display el mensaje 
  }
  
 }
 else
 {

    lcd.setCursor(0,1);  //colocamos el cursor en fila 0 y columna 1
    lcd.clear(); //se limpia la pantalla
    delay(500);
    lcd.print("Esperando Tarjeta"); //Mostrando mensaje de inicio
   
    lcd.setCursor(12,3);
    lcd.print(now.hour(), DEC);//muestra la hora
    lcd.print(':');
    lcd.print(now.minute(), DEC);//muestra los minutos 
    lcd.print(':');
    lcd.print(now.second(), DEC);//muestra los segundos
    
  }
  
 
 delay(1000);

}

// Funcion que devuelve un true => si hay lectura de taregta o un false=> si no hay lectura. si hay lectura guarda el numero de targeta el la varible idTargeta
bool LeerTarjeta() 
{
  if(lectorTargeta.available()) // verifico si hay targeta o lectura de taegeta en el lector, si hay lectura entra al if
  {

    idTargeta = String(lectorTargeta.getCode(), HEX); // el objeto devuelve el numero de targeta lo tranforma en string para poder guardar en la variable global idtargeta
    idTargeta.toUpperCase(); // tranforma el numero de targeta que est un string en mayusculas
    return true;   // retorna true o sea realizo la lectura
  }
  else
    return false; // si no hay lectura devuelve false
}

// Funcion que envia los datos al servidor, envia el numero de targeta que esta enla variable global idTargeta
void EnviarDatos()
{
  if (WiFi.status() == WL_CONNECTED) // verifica que hay conexion de wifi
  { 
     HTTPClient http;  // creo el objeto http que enviara los datos al servidor o la pagina
     String datos_a_enviar =  "idTargeta=T" + idTargeta;  // los datos se envian en un url, entonces necesito una variable que trasporte el numero de target esta se llamara idTaregta y le concateno el numero de targeta

     client.connect("67.227.214.78",80); // IP del servidor Web y puerto de comunicacion

     http.begin(client,"http://servicehebe.epet5-santamaria.edu.ar/smshebe/asistencias.php"); // direcccion de la pagina que recibira el numero de targeta
     http.addHeader("Content-Type", "application/x-www-form-urlencoded"); // defino texto plano.. indico que es texto plano

     int codigo_respuesta = http.POST(datos_a_enviar); // guarda el codigo de respuesta del servidor del servidor al recibir la targeta, esta repuesta la podemos utilizar para mostrar por el display

     if (codigo_respuesta>0) // verifico el codigo de respuesta. existen difirentes codigos de respuestas de los  servidores http y son numeros
     {
        Serial.println("Código HTTP: "+ String(codigo_respuesta)); // muestro el codigo de respuesto del servidor por el puerto serial es solo para verificar
        if (codigo_respuesta == 200) // verifico que el codigo de respuesta sea 200, este numero de respuesta significa que todo esta OK. (pero exieten difientes codigos)
        {
          lcd.setCursor(0,1); //colocamos el cursor en fila 0 y columna 1
          lcd.clear();//se limpia la pantalla
          lcd.print("Bienvenido!"); //Mostrando mensaje de registro
          delay(500);
          

          String cuerpo_respuesta = http.getString(); // obtengo la respuesta y la guardo en una variable
          Serial.println("El servidor respondió: "); // mensaje por el puerto serial
          Serial.println(cuerpo_respuesta); //  visulaizo el codigo de respuesata del servidor solo para chekear

        
        }else{
          lcd.setCursor(0,1); //colocamos el cursor en fila 0 y columna 1 
          lcd.clear(); //se limpia la pantalla
          lcd.print("Error Inesperado"); //Mostrando mensaje de error
          }

     }else 
        {
           

          Serial.print("Error enviado POST, código: "); // mensaje por el puerto serial
          Serial.println(codigo_respuesta); // visualizo el codigo de respuesta del servidor para ver que tipo de codigo es y corregir  si es necesario
        }
        
        http.end();  // libero recursos        
   }
   else
   {
    Serial.println("Error en la conexion WIFI");    // mensaje si no hay conexion wifi, este mensaje podemos visualizarlo por el display
   }
    //delay(2000); 
}










  
