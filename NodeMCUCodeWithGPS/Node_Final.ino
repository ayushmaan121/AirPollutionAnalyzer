/*
 * Code to connect NodeMCU to the webserver at airmonitor1.000webhostapp.com 
 * DHT sensor is connected at D4
 * MQ135 sensor is connected at A0
 * SDA of i2c scanner to D2 and SCL to D1
 * NeoGPS Sensor: RxPin : D7 , TxPin : D6
 * variables used : variable name - purpose
 *                  tempValue     - temperature sensing from DHT
 *                  humidValue    - humidity from DHT
 *                  ppmValue      - ppm coming from MQ135
 *                  latValue      - lattitude value from GPS
 *                  longValue     - longitude value from GPS
 *                  node_id       - node number at which data is being send
 *                  ssid          - name of the WiFi Hotspot used'
 *                  password      - password of that WiFi network
 *                  host          - url of the server at which data is send
 *                  httpPort      - port value used for the communication between webserver and NodeMCU
 *                  url           - url generated to send data from NodeMCU to database at webServer
 * Method used for sending values to the webserver- GET
 * 
 */
#include<ESP8266WiFi.h>
#include "DHT.h"
#include<Wire.h>
#include<LiquidCrystal_I2C.h>
#include <TinyGPS++.h>
#include <SoftwareSerial.h>
const int node_id = 1;
double latValue,lonValue;
const int DHTPin = 2; //D4
#define DHTTYPE DHT22
float tempValue,humidValue;
const int ppm_sensor = A0; //A0
int ppmValue;
DHT temp_humid(DHTPin,DHTTYPE);
static const int RX = 12, TX = 13;   
        unsigned long start;
        
  volatile float minutes, seconds;
volatile int degree, secs, mins;
        double lat_val, lng_val, alt_m_val;
        uint8_t hr_val, min_val, sec_val;
        bool loc_valid, alt_valid, time_valid;
TinyGPSPlus gps;
int timer=0;
SoftwareSerial GPSss(RX, TX);
const int lightPinB= 0,lightPinG = 14, lightPinR= 15;
static const uint32_t GPSBaud = 4800;
LiquidCrystal_I2C lcd(0x3F,16,2); // SDA to D2 SCL to D1
const int httpPort = 80;
WiFiClient client;
const char* ssid = "No";
const char* password = "connected2";
const char* host = "airmonitor1.000webhostapp.com";
void setup() {
  initialize();
}
void loop(){
  readData();
  lcdDisplay();
  sendToServer();
}
void initialize(){
  Serial.begin(115200);       
  GPSss.begin(GPSBaud);
  temp_humid.begin();
  pinMode(lightPinR, OUTPUT);
  pinMode(lightPinG, OUTPUT);
  pinMode(lightPinB, OUTPUT);
  digitalWrite(lightPinR, LOW);
  digitalWrite(lightPinG, LOW);
  digitalWrite(lightPinB, LOW);
  lcd.begin();
  lcd.setCursor(0,0);
  //Red();
  lcd.print("Connecting..."); 
  Serial.println("Connecting to wifi: ");
  Serial.println(ssid);
  Serial.flush();
  WiFi.begin(ssid, password);
  while (WiFi.status() != WL_CONNECTED) {
    delay(1000);
    Serial.print(".");
  }
  //Red();
  lcd.clear();
  lcd.setCursor(0,0);
  lcd.print("IP address: ");
  lcd.setCursor(0,1);
  delay(2000);
  lcd.print(WiFi.localIP());
  Serial.println("IP address: ");
  Serial.print(WiFi.localIP());
  Serial.print("Netmask: ");
  Serial.println(WiFi.subnetMask());
  Serial.print("Gateway: ");
  Serial.println(WiFi.gatewayIP());
  }
void readData(){
  tempValue = temp_humid.readTemperature();
  humidValue = temp_humid.readHumidity();
  ppmValue = analogRead(ppm_sensor);
  gpsread(); 
  tempValue = temp_humid.computeHeatIndex(tempValue, humidValue, false);
}
void lcdDisplay(){
  lcd.clear();
  lcd.setCursor(0, 0);
  lcd.print("Printing Values..");
  delay(1000);
  lcd.clear();
  lcd.print("lat=");
  lcd.setCursor(4, 0);
  lcd.print(lat_val);
  lcd.setCursor(0, 1);
  lcd.print("lng=");
  lcd.setCursor(4, 1);
  lcd.print(lng_val);
  delay(2000);
  }
void sendToServer(){
  //Green();
  lcd.clear();
  lcd.setCursor(0, 0);
  lcd.print("PPM=");
  lcd.setCursor(4, 0);
  lcd.print(ppmValue);
  lcd.setCursor(0, 1);
  lcd.print("T/H=");
  lcd.setCursor(4, 1);
  lcd.print(tempValue);
  lcd.print("/");
  lcd.print(humidValue);
  Serial.print("connecting to ");
  Serial.println(host);
  while(!client.connect(host, httpPort)) {
    Serial.print(".");
   }
  String url = "/data/insert" + String(node_id) + ".php?ppm=" + String(ppmValue) + "&temp="+ String(tempValue) + "&humid=" + String(humidValue) + "&lattitude=" + String(lat_val,6) + "&longitude=" +String(lng_val,6);
  Serial.println("URL Requested:");
  Serial.println(url);
    client.print(String("GET ") + url + " HTTP/1.1\r\n" +
               "Host: " + host + "\r\n" + 
               "Connection: close\r\n\r\n");
  //delay(15000);
  //lcd.clear();
  while(client.available()){
    String disp = client.readStringUntil('\r');
    Serial.print(disp);
  }
  Serial.println();
  Serial.println("closing connection");
  delay(3000); 
}
void gpsread() {
        smartDelay(1000); /* Generate precise delay of 1ms */

        lat_val = gps.location.lat(); /* Get latitude data */
        loc_valid = gps.location.isValid(); /* Check if valid location data is available */
        lng_val = gps.location.lng(); /* Get longtitude data */
        alt_m_val = gps.altitude.meters();  /* Get altitude data in meters */
        alt_valid = gps.altitude.isValid(); /* Check if valid altitude data is available */
        hr_val = gps.time.hour(); /* Get hour */
        min_val = gps.time.minute();  /* Get minutes */
        sec_val = gps.time.second();  /* Get seconds */
        time_valid = gps.time.isValid();  /* Check if valid time data is available */
        if (!loc_valid)
        {     
          Serial.print("Latitude : ");
          Serial.println("*****");
          Serial.print("Longitude : ");
          Serial.println("*****");
        }
        else
        { 
          DegMinSec(lat_val);
          Serial.print("Latitude in Decimal Degrees : ");
          Serial.println(lat_val, 6);
          Serial.print("Latitude in Degrees Minutes Seconds : ");
          Serial.print(degree);
          Serial.print("\t");
          Serial.print(mins);
          Serial.print("\t");
          Serial.println(secs);
          DegMinSec(lng_val); /* Convert the decimal degree value into degrees minutes seconds form */
          Serial.print("Longitude in Decimal Degrees : ");
          Serial.println(lng_val, 6);
          Serial.print("Longitude in Degrees Minutes Seconds : ");
          Serial.print(degree);
          Serial.print("\t");
          Serial.print(mins);
          Serial.print("\t");
          Serial.println(secs);
        }
        if (!alt_valid)
        {
          Serial.print("Altitude : ");
          Serial.println("*****");
        }
        else
        {
          Serial.print("Altitude : ");
          Serial.println(alt_m_val, 6);    
        }
        if (!time_valid)
        {
          Serial.print("Time : ");
          Serial.println("*****");
        }
        else
        {
          char time_string[32];
          sprintf(time_string, "Time : %02d/%02d/%02d \n", hr_val, min_val, sec_val);
          Serial.print(time_string);    
        }
          //Serial.println("ayushmaan");
  lcd.print("Printing Values...");
  delay(1000);
  lcd.clear();
  lcd.print("lat=");
  lcd.print(lat_val,6);
  lcd.setCursor(0,1);
  lcd.print("lng=");
  lcd.print(lng_val,6);
  delay(2000);
  lcd.clear();
}
static void smartDelay(unsigned long ms)
{
  unsigned long start = millis();
  do 
  {
    while (GPSss.available())  /* Encode data read from GPS while data is available on serial port */
      gps.encode(GPSss.read());
/* Encode basically is used to parse the string received by the GPS and to store it in a buffer so that information can be extracted from it */
  } while (millis() - start < ms);
}

void DegMinSec( double tot_val)   /* Convert data in decimal degrees into degrees minutes seconds form */
{  
  degree = (int)tot_val;
  minutes = tot_val - degree;
  seconds = 60 * minutes;
  minutes = (int)seconds;
  mins = (int)minutes;
  seconds = seconds - minutes;
  seconds = 60 * seconds;
  secs = (int)seconds;
}
