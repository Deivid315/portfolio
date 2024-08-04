const express = require('express');
const http = require('http');
const socketIo = require('socket.io');
const jwt = require('jsonwebtoken');
const sodium = require('sodium-native');
const { DateTime } = require('luxon');

const timezone = 'America/Sao_Paulo';

const dateTime = DateTime.now().setZone(timezone);

require('dotenv').config();

function base64Encode(input) {
    return Buffer.from(input).toString('base64');
}

function sodiumCryptoGenerichashBase64(input) {
    const base64Input = base64Encode(input);

    const hashBuffer = Buffer.alloc(40);

    sodium.crypto_generichash(hashBuffer, Buffer.from(base64Input));

    return base64Encode(hashBuffer);
}

const app = express();
const server = http.createServer(app);
const io = socketIo(server, {
    cors: {
        origin: "*",
        methods: ["GET", "POST"]
    }
});

const secretKey = process.env.KEY_JWT;

io.use((socket, next) => {
    const token = socket.handshake.auth.token.token;
    if (!token) {
        return next(new Error('Autenticação falhou: token não fornecido'));
    }
    jwt.verify(token, secretKey, (err, decoded) => {
        if (err) {
            console.log('Erro na verificação do token:', err);
            return next(new Error('Autenticação falhou: token inválido'));
        }
        socket.cod = decoded.data.cod;
        next();
    });
});

io.on('connection', (socket) => {
    const data = new Date;
    socket.on('joinRoom', (cod) => {
        const envie = sodiumCryptoGenerichashBase64(cod);
        if (socket.cod === envie) {
            socket.join(cod);

            console.log(`Cliente entrou na sala: ${cod}`, data.toString());
        } else {
            socket.disconnect();
            console.log('Autenticação de sala falhou');
        }
    });

    socket.on('disconnect', () => {
        console.log('Cliente desconectado', data.toString());
    });
});

app.use(express.json());

app.get('/emit', (req, res) => {
    return res.status(511).send('Não autorizado');
});

app.post('/emit', (req, res) => {
    const { jwt: jwtToken, texts, alerta } = req.body;
    if (jwtToken && texts) {
        const jwtObject = JSON.parse(jwtToken);
        jwt.verify(jwtObject.token, secretKey, (err, decoded) => {
            if (err) {
                return res.status(401).send('Não autorizado');
            }

            const cod = decoded.data.cod;

            const userSocket = Array.from(io.sockets.sockets.values()).find(socket => socket.cod === cod);
            if (!userSocket) {
                console.log('Não conectado com texto e jwt');
                return res.status(511).send('Usuário não está conectado');
            }

            userSocket.emit('35159AE3F3AC6A569D7A632B76E940D8D4929098909BEDC9DE94A7A0B1441F0947FF9D589BD3A357B72875C543AC3C0F6C13FC081C137392A5E83AAE12942BFE', { texts });

            console.log('enviado com sucesso');
            return res.status(200).send('Sucesso');
        });
    } else if (jwtToken && alerta) {
        const jwtObjec2 = JSON.parse(jwtToken);
        jwt.verify(jwtObjec2.token, secretKey, (err, decoded) => {
            if (err) {
                console.log('Erro na verificação do token JWT:', err);
                return res.status(401).send('Não autorizado');
            }

            const cod2 = decoded.data.cod;

            const userSocket2 = Array.from(io.sockets.sockets.values()).find(socket => socket.cod === cod2);
            if (!userSocket2) {
                console.log('nao conectado com alerta');
                return res.status(404).send('Não autorizado');
            }

            userSocket2.emit('357E4734BAE147C013F4B8AC600BB16EA953645C6C462086D29286C05A0B5AFFA213690AE4D0035AC354BB1E89DDCABF3D57C929138E6C4CCE63F9E0DC9D81E7', { alerta });

            console.log('enviado ao cliente a mensagem de erro');
            return res.status(200).send('Sucesso'); 
        });
    } else {
        console.log(req);
        console.log(req.body);
        console.log('Erro: parâmetros inválidos');
        return res.status(404).send('não permitido');
    }
});

server.listen(3000, () => {
    console.log('Servidor Socket.IO escutando na porta 3000');
});
