#include <Wire.h>
#include <WiFi.h>
#include "rgb_lcd.h"

rgb_lcd lcd;
char ssid[] = "event";
int status = WL_IDLE_STATUS;
WiFiClient client;
char server[] = "www.safespace.co";

int charCount = 0;

unsigned long lastConnectionTime = 0;           // last time you connected to the server, in milliseconds
const unsigned long postingInterval = 10*1000;  // delay between updates, in milliseconds

String tweetText = "Test Tweet Blah Blah Blah";


void setup()
{
  // Set up outputs
  lcd.begin(16, 2);

  // Connect to WiFi
  while (status != WL_CONNECTED) {
    status = WiFi.begin(ssid);
    delay(10000);
  }
}

void loop()
{
  // Set text
  lcd.setCursor(0,0);
  lcd.print("Recent Tweet:");
  lcd.setCursor(0,1);

  charCount = 0;
  while (client.available()) {
    char tweetText = client.read();
    charCount = charCount + 1;
    lcd.print(tweetText);
  }

  // Scroll text
  for (int positionCounter = 0; positionCounter < (charCount - 1); positionCounter++) {
    lcd.scrollDisplayLeft();
    delay(400);
  }

  // Clear for next iteration
  lcd.clear();

  delay(5000);

  if(!client.connected() && (millis() - lastConnectionTime > postingInterval)) {
    httpRequest();
  }
}

void httpRequest() {
  // If there's a successful connection:
  if (client.connect(server, 80)) {

    // Send the HTTP GET request:
    client.println("GET /latest HTTP/1.1");
    client.println("Host: www.safespace.co");
    client.println("User-Agent: arduino-wifi");
    client.println("Connection: close");
    client.println();

    // Note the time that the connection was made:
    lastConnectionTime = millis();
  }
}



