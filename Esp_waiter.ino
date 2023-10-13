
#include <ESP8266WiFi.h>
#include <ESP8266HTTPClient.h>

const char* ssid = "****";     // Change this to your WiFi SSID
const char* password = "****"; // Change this to your WiFi password
const char* serverUrl = "http://****.***/waiter.php"; // Change this to your server URL

const int buttonPin = 14; // The GPIO pin where the button is connected

void setup() {
  Serial.begin(115200);
  pinMode(buttonPin, INPUT_PULLUP); // Set the button pin as input with pull-up resistor
  connectToWiFi();
}

void loop() {
  int buttonState = digitalRead(buttonPin);

  // Check if the button is pressed (button is active low)
  if (buttonState == LOW) {
    Serial.println("Button pressed");
    sendWaiterRequest();
    delay(1000); // Debounce the button press
  }
}

void connectToWiFi() {
  WiFi.begin(ssid, password);
  while (WiFi.status() != WL_CONNECTED) {
    delay(1000);
    Serial.println("Connecting to WiFi...");
  }
  Serial.println("Connected to WiFi");
}

void sendWaiterRequest() {
  HTTPClient http;
  WiFiClient client; // Create a WiFiClient object

  // Add your custom headers here if needed
  // http.addHeader("HeaderName", "HeaderValue");

  // Create a JSON payload with the ESP8266's unique ID and table number
  String payload = "{\"esp_id\":\"" + WiFi.macAddress() + "\",\"table_number\":1}";

  http.begin(client, serverUrl); // Use the updated begin method

  // Set headers
  http.addHeader("Content-Type", "application/json");

  int httpResponseCode = http.POST(payload);

  if (httpResponseCode > 0) {
    Serial.print("HTTP Response code: ");
    Serial.println(httpResponseCode);
  } else {
    Serial.print("HTTP Error: ");
    Serial.println(httpResponseCode);
  }

  http.end();
}



