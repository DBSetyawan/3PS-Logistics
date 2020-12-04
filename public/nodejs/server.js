// var app = require('express')();
// var http = require('http').Server(app);
// var io = require('socket.io')(http);
// var Redis = require('ioredis');
// var redis = new Redis();
// redis.subscribe('test-channel', function(err, count) {
// });
// redis.on('message', function(channel, message) {
//     console.log('Message Recieved: ' + message);
//     message = JSON.parse(message);
//     io.emit(channel + ':' + message.event, message.data);
// });
// http.listen(5000, function(){
//     console.log('Listening on Port 3000');
// });

// var app = require('express');
// var server = require('http').Server(app);
// var io = require('socket.io').listen(server);
// var router = app.Router();

// io.on('connection', function(socket){
//     console.log('Socket, on connection, now sending/receiving on `webhooks`' );
//     // socket.join("test");
//     socket.on('webhooks', function(data){
//         console.log(data);
//     });


// });
// Require Express (HTTP server)
// http://expressjs.com
// var express = require('express');
// var app = express();
// var server = require('http').createServer(app);

// // Configure Express server
// app.set(function(){
//   app.use(express.bodyParser());
//   app.use(express.errorHandler({
//     dumpExceptions: true,
//     showStack: true
//   }));
// });

// // Webhook endpoint
// app.post("/client_event", function(req, res) {
//   var timestamp = req;

//   console.log(timestamp);

//   // Respond with a success code
//   res.sendStatus(200);
// });
// app.get('/', (req, res) => {
//     res.send('Hello World');
//   });


// // Set up HTTP server to listen on system port, or port 5000
// var sdds = server.listen(process.env.PORT || 5000);
// var io = require('socket.io').listen(sdds);

// var apps = require('express')();
// var servers= require('http').Server(apps);
// var socketJS = require('socket.io')(servers);


// app.socketsio = io;
// var socket;
// io.on('connection', function (sock) {
//     console.log('Connected');
//     socket = sock;
// });

// server.listen(3000);


// router.get('/', function (req, res) {
//     res.render('index', model);

//     myEmitter.on('checkNotification', function(data) {
//         // Process data
//     })
// });

// router.post('/check', function (req, res) {
//     console.log(req.body);

//     myEmitter.emit('checkNotification', 'Your data')

//     res.end();
// });

var express = require('express'), bodyParser = require('body-parser');
var app = express();
var server = require('http').createServer(app);
var io = require('socket.io')(server);
var router = express.Router();

const EventEmitter = require('events');
const myEmitter = new EventEmitter();

app.use(bodyParser.urlencoded({ extended: false }));
app.use(bodyParser.json());
app.use(express.static('static'));
// app.use(express.static(__dirname + '/bower_components'));
app.get('/', function(req, res,next) {
    res.sendFile(__dirname + '/resources/views/admin/index.blade.php');
});


app.post("/client_event", function(req, res) {
    // let to = req.body.to;
    let progress = req.body;
    // let fromNumber = req.body.from;
    // let callStatus = req.body.CallStatus;
    // let callSid = req.body.callSid;

    // io.emit('call progress event', { progress});
 
    res.write('<html>');
res.write('<body>');
res.write('<h1>Hello, World!</h1>');
res.write('</body>');
res.write('</html>');
    res.end();
    // console.log(progress);
    res.send('Event received');
    res.sendStatus(200);
    res.json(progress);
    
  });

server.listen(4200);


io.on('connection', function(FromClients) {
    // console.log('Client connected...');
    
    FromClients.on('join', function(data) {
    	console.log(data);
    });

    FromClients.on('join', function(data) {
    	console.log(data);
        FromClients.emit('messages', 'Socket from server');
    });

    FromClients.on('disconnect', () => {
        console.log('waiting reconnection to server..');
      });

});
    
   