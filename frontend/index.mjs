// const express = require("express");
// const app = express();
// const http = require("http");
// const server = http.createServer(app);
// const { Server } = require("socket.io");
// const io = new Server(server);

// app.get("/", (req, res) => {
//     res.sendFile(__dirname + "/index.html");
//   });

// io.on("connection", client => {
//     client.emit('init', { data: "Hello World" });
// });

// io.listen(3000);

import {WebSocketServer} from 'ws';

const server = new WebSocketServer({port: 3000});

server.on("connection", (socket) => {
    socket.send(JSON.stringify({
        type: "Hello from server",
        content: [1, "2"]
    }));

    socket.on("message", (data) => {
        const packet = JSON.parse(data);

        switch (packet.type) {
            case "Hello from client":
                break
        }
    })
})