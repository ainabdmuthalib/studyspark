const WebSocket = require('ws');
const { MongoClient } = require('mongodb');

const WS_PORT = 8080; // WebSocket server port
const MONGO_URI = "mongodb://localhost:27017"; // MongoDB connection URI
const DB_NAME = "studyspark"; // Database name

const wss = new WebSocket.Server({ port: WS_PORT });
console.log(`WebSocket server running on ws://localhost:${WS_PORT}`);

// Connect to MongoDB
MongoClient.connect(MONGO_URI, { useUnifiedTopology: true }, (err, client) => {
    if (err) {
        console.error("MongoDB connection error:", err);
        return;
    }

    const db = client.db(DB_NAME);
    const sessions = db.collection('study_sessions');

    // Watch for changes in the study_sessions collection
    const changeStream = sessions.watch();

    changeStream.on('change', (change) => {
        if (change.operationType === 'insert' || change.operationType === 'update') {
            const userId = change.fullDocument.user_id; // Get the user ID from the change document

            // Notify all connected clients about the change
            wss.clients.forEach(client => {
                if (client.readyState === WebSocket.OPEN) {
                    client.send(JSON.stringify({ action: 'updateTime', userId }));
                }
            });
        }
    });

    // WebSocket connection handler
    wss.on('connection', (ws, req) => {
        console.log('New client connected');

        ws.on('close', () => {
            console.log('Client disconnected');
        });
    });
});
