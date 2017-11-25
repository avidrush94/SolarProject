#include <SPI.h>
#include <Servo.h>
#include <Ethernet.h>
#include <LiquidCrystal.h>
byte mac[] = {};
char server[] = "solarsolutions.esy.es";
IPAddress ip();
IPAddress myDns(31,170,164,249);
EthernetClient client;
String str;
Servo dayServo;
Servo yearServo;
//LiquidCrystal lcd(12, 11, 5, 4, 3, 2);
void connectionSetup() {
  // set up the LCDs number of columns and rows:
  //lcd.begin(16, 2);
  Serial.begin(9600);
  while (!Serial) {
  }
  if (Ethernet.begin(mac) == 0) {
    Serial.println("Failed to configure Ethernet using DHCP");
    Ethernet.begin(mac, ip,myDns);
  }
  delay(1000);
  Serial.println("connecting...");
  if (client.connect(server, 80)) {
    Serial.println("connected");
    //lcd.print("hello, world!");
    client.println("GET /setup.php HTTP/1.1");
    client.println("Host: solarsolutions.esy.es");
    client.println("Connection: close");
    client.println();
  } else {
    Serial.println("connection failed");
  }
}
void connectionSetup(String id,int voltage, int current) {
  // set up the LCDs number of columns and rows:
  //lcd.begin(16, 2);
  Serial.begin(9600);
  while (!Serial) {
  }
  if (Ethernet.begin(mac) == 0) {
    Serial.println("Failed to configure Ethernet using DHCP");
    Ethernet.begin(mac, ip,myDns);
  }
  delay(1000);
  Serial.println("connecting");
  if (client.connect(server, 80)) {
    Serial.println("connected");
    //lcd.print("hello, world!");
    String temp = "GET /upload.php?id="+id+"&voltage="+voltage+"&current="+current+" HTTP/1.1";
    client.println(temp);
    client.println("Host: solarsolutions.esy.es");
    client.println("Connection: close");
    client.println();
  } else {
    Serial.println("connection failed");
  }
}
float readVoltage() {
  float RawValue = analogRead(A0);
  float Voltage = (RawValue / 1024.0) * 5000; // Gets you mV
  return Voltage;
}
float readCurrent() {
  float RawValue = analogRead(A0);
  float Voltage = (RawValue / 1024.0) * 5000; // Gets you mV
  float current = ((Voltage - 2500) / 185);
  return current;
}
void setup() {
  dayServo.attach(9);
  yearServo.attach(8);
  connectionSetup();
}
void loop() {
  while(client.available()) {
    char c = client.read();
    str = str+c;
  }
  for(int i=177;i<str.length(); i++) {
    Serial.print(str.charAt(i));
    }
  if (!client.connected()) {
    Serial.println();
    Serial.println("disconnecting.");
    client.stop();
    String temp = str.substring(177,181);
    //Serial.println("temp=");
    Serial.println(temp);
    float dayCoord = temp.toFloat();
    //Serial.println("lat=");
    Serial.println(dayCoord);
    dayServo.write(dayCoord);
    Serial.println();
    temp = str.substring(186,191);
    //Serial.println("temp=");
    Serial.println(temp);
    float yearCoord = temp.toFloat();
    //Serial.println("lat=");
    Serial.println(yearCoord);
    yearServo.write(yearCoord);
    Serial.println();
    str="";
    float voltage = readVoltage();
    float current = readCurrent();
    String id = "ard1234";
    //while (!client.connect(server,80));
    connectionSetup(id,voltage,current);
    delay(100);
  }
}
