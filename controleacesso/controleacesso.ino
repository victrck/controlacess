#include <ESP8266WiFi.h>     //Include Biblioteca Esp 
#include <WiFiClient.h>
#include <ESP8266WebServer.h>
#include <ESP8266HTTPClient.h>
#include <SPI.h>
#include <MFRC522.h>        //Include Biblioteca RFID 

#define SS_PIN D8 //Definição de pinos
#define RST_PIN D3
#define Rele D0


MFRC522 mfrc522(SS_PIN, RST_PIN); // Criando uma instancia do leitor RFID

const char *ssid = "UFPI";  //WIFI CONFIG UFPI
const char *password = "";


const char *host = "192.168.18.9";   //endereço IP do servidor UFPI


String getData , Link;
String CardID = "";

void setup() {
  pinMode (Rele, OUTPUT);
  delay(1000);
  Serial.begin(115200);
  SPI.begin();  // iniciar SPI 
  mfrc522.PCD_Init(); // iniciar leitor rfid

  WiFi.mode(WIFI_OFF);        //Impede o problema de reconexão (demorando muito para conectar)
  delay(1000);
  WiFi.mode(WIFI_STA);        //oculta a visualização do ESP como ponto de acesso wifi

  WiFi.begin(ssid, password);     //Connectando ao roteador wifi
  Serial.println("");

  Serial.print("Conectando em  ");
  Serial.print(ssid);
  // Esperando comunicação
  while (WiFi.status() != WL_CONNECTED) {
    delay(500);
    Serial.print(".");
  }

  //Se conectou mostra o IP no console 
  Serial.println("");
  Serial.println("Conectado");
  Serial.print("IP address: ");
  Serial.println(WiFi.localIP());  //Ip do ESP


}

void loop() {
  if (WiFi.status() != WL_CONNECTED) {
    WiFi.disconnect();
    WiFi.mode(WIFI_STA);
    Serial.print("Reconectando em ");
    Serial.println(ssid);
    WiFi.begin(ssid, password);

    while (WiFi.status() != WL_CONNECTED) {
      delay(500);
      Serial.print(".");
    }
    Serial.println("");
    Serial.println("Connected");
    Serial.print("IP address: ");
    Serial.println(WiFi.localIP());  //Ip do ESP
  }

  //Procurando um cartão RFID
  if ( ! mfrc522.PICC_IsNewCardPresent()) {
    return;                                   //deve iniciar o loop se não houver cartão presente
  }
  // Lendo um dos cartões
  if ( ! mfrc522.PICC_ReadCardSerial()) {
    return;                            //se o cartão de leitura serial (0) retornar 1, a estrutura do uid conterá o ID do cartão de leitura.
  }

  for (byte i = 0; i < mfrc522.uid.size; i++) {
    CardID += mfrc522.uid.uidByte[i];
  }

  HTTPClient http;    //Declarando um objeto da classe HTTPClient

  //Usando o metodo GET, comunicação com o servidor
  getData = "?CardID=" + CardID;  //Adicionando "?" na frente
  Link = "http://192.168.18.9/controlacess/postdemo.php" + getData;

  http.begin(Link);

  int httpCode = http.GET();            //Enviando a requisição
  delay(10);
  String payload = http.getString();    //payload recebe a resposta

  Serial.println(httpCode);   //Print codigo de retorno HTTP 
  Serial.println(payload);    //Print resposta do servidor
  Serial.println(CardID);     //Print cartão RFID

    if(payload == "Acesso Permitido"){
      digitalWrite(Rele,HIGH);
      delay(500);  //Post Data a cada 5 segundos
    }
  delay(500);

  CardID = "";
  getData = "";
  Link = "";
  http.end();  //Fechar Conexão

    digitalWrite(Rele,LOW);
}
