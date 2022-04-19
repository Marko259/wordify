const express = require("express");
const app = express();
const http = require("http");
const server = http.createServer(app);
const { Server } = require("socket.io");
const io = new Server(server);

app.get("/", (req, res) => {
  res.sendFile(__dirname + "/index.html");
});

function getDateTime() {
  var today = new Date();
  var date = today.getFullYear() + "-" + (today.getMonth() + 1) + "-" + today.getDate();
  var time = today.getHours() + ":" + today.getMinutes() + ":" + today.getSeconds();
  var dateTime = date + " " + time;
  return dateTime;
}

io.on("connection", (socket) => {
  console.log(getDateTime() + " a user connected");

  socket.on("disconnect", () => {
    console.log(getDateTime() + " user disconnected");
  });

  socket.on("chat message", (msg) => {
    io.emit("chat message", msg);
  });

  socket.broadcast.emit("hi");
});

server.listen(3000, () => {
  console.log("listening on *:3000");
});
