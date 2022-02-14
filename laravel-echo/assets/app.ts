import Echo from 'laravel-echo';
require('pusher-js');

const echo = new Echo({
    broadcaster: 'pusher',
    withoutInterceptors: true,

    key: process.env.SOKETI_APP_KEY,
    wsHost: process.env.WS_HOST,
    wsPort: process.env.WS_PORT,
    wssPort: process.env.WSS_PORT,
    forceTLS: false,
    disableStats: true,
    enabledTransports: ['ws', 'wss'],
    encrypted: true,
});

const logger = document.getElementById('logger');

const dumpMessage = (e) => {
    const element = document.createElement('p');
    element.textContent = `From ws: ID: ${e.id}`;

    logger?.appendChild(element);
}

// echo.channel('app').listen('.foo', (e) => dumpMessage(e));
echo.listen('app', '.foo', (e) => dumpMessage(e));
