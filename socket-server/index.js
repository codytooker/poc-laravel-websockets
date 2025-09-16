const WebSocket = require('ws');

const PORT = 8081;
const wss = new WebSocket.Server({ port: PORT });

console.log(`WebSocket server running on ws://localhost:${PORT}`);

wss.on('connection', (ws) => {
    console.log('Client connected');

    ws.on('message', (message) => {
        console.log(`Received from client: ${message}`);

        wss.clients.forEach((client) => {
            if (client.readyState === WebSocket.OPEN) {
                client.send(message);
            }
        });
    });

    ws.on('close', () => {
        console.log('Client disconnected');
    });
});
