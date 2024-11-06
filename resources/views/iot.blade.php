<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Web Device Security Testing</title>
    <style>
        body { font-family: Arial, sans-serif; padding: 20px; }
        .container { max-width: 600px; margin: 0 auto; }
        .section { margin-bottom: 20px; }
        label { font-weight: bold; }
        input, textarea { width: 100%; padding: 8px; margin: 5px 0; }
        button { padding: 10px; cursor: pointer; }
    </style>
</head>
<body>
    <div class="container">
        <h2>Web Device Security Testing Interface</h2>

        <!-- Device Registration Section -->
        <div class="section" id="register-device">
            <h3>Register Device</h3>
            <label for="device-name">Device Name:</label>
            <input type="text" id="device-name">
            <button onclick="registerDevice()">Register Device</button>
            <p id="registration-result"></p>
        </div>

        <!-- Send Encrypted Message Section -->
        <div class="section" id="send-message" style="display: none;">
            <h3>Send Encrypted Message</h3>
            <label for="device-token">Device Token:</label>
            <input type="text" id="device-token" readonly>

            <label for="message">Message:</label>
            <textarea id="message" rows="3"></textarea>
            <button onclick="sendMessage()">Send Message</button>
            <p id="send-result"></p>
        </div>

        <!-- Receive and Decrypt Message Section -->
        <div class="section" id="receive-message" style="display: none;">
            <h3>Receive and Decrypt Message</h3>
            <label for="encrypted-message">Encrypted Message:</label>
            <input type="text" id="encrypted-message" readonly>

            <button onclick="receiveMessage()">Decrypt Message</button>
            <p id="receive-result"></p>
        </div>
    </div>

    <script>
        async function registerDevice() {
            const name = document.getElementById("device-name").value;
            const response = await fetch('/api/register-device', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ name: name })
            });
            const data = await response.json();
            if (data.device_token) {
                document.getElementById("registration-result").innerText = "Device registered successfully!";
                document.getElementById("device-token").value = data.device_token;
                document.getElementById("send-message").style.display = 'block';
            } else {
                document.getElementById("registration-result").innerText = "Error registering device.";
            }
        }

        async function sendMessage() {
            const token = document.getElementById("device-token").value;
            const message = document.getElementById("message").value;
            const response = await fetch('/api/send-message', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ device_token: token, message: message })
            });
            const data = await response.json();
            if (data.encrypted_message) {
                document.getElementById("send-result").innerText = "Message sent successfully!";
                document.getElementById("encrypted-message").value = data.encrypted_message;
                document.getElementById("receive-message").style.display = 'block';
            } else {
                document.getElementById("send-result").innerText = "Error sending message.";
            }
        }

        async function receiveMessage() {
            const token = document.getElementById("device-token").value;
            const encryptedMessage = document.getElementById("encrypted-message").value;
            const response = await fetch('/api/receive-message', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ device_token: token, encrypted_message: encryptedMessage })
            });
            const data = await response.json();
            if (data.decrypted_message) {
                document.getElementById("receive-result").innerText = "Decrypted Message: " + data.decrypted_message;
            } else {
                document.getElementById("receive-result").innerText = "Error decrypting message.";
            }
        }
    </script>
</body>
</html>
