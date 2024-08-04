import Cookies from 'js-cookie';
import io from 'socket.io-client';

export function configurarSocket() {
    const BBCookie = Cookies.get('base');
    const IDCookie = JSON.parse(Cookies.get('id_'));

    const socket = io('http://localhost:3000', {
        auth: {
            token: IDCookie
        }
    });

    socket.emit('joinRoom', BBCookie);

    socket.on('357E4734BAE147C013F4B8AC600BB16EA953645C6C462086D29286C05A0B5AFFA213690AE4D0035AC354BB1E89DDCABF3D57C929138E6C4CCE63F9E0DC9D81E7', function (data) {
        console.log(data);
        const reload = document.getElementById("reloadButton");
        reload.textContent = data.alerta;
        reload.style.display = 'flex';
        reload.addEventListener("click", function () {
            window.location.reload();
        });
    });
    return socket;
}

