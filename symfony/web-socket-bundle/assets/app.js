/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

import WS from '../vendor/gos/web-socket-bundle/public/js/websocket.js';
const websocket = WS.connect("ws://ws.lvh.me");
const logger = document.getElementById('logger');

const log = (message, object = {}) => {
    const htmlParagraphElement = document.createElement('p');
    htmlParagraphElement.textContent = message

    const preElement = document.createElement('pre');
    preElement.textContent = JSON.stringify(object);

    const divElement = document.createElement('div');
    divElement.appendChild(htmlParagraphElement).appendChild(preElement);

    logger.prepend(divElement);
}

websocket.on("socket/connect", function (session) {
    document.getElementById('btnSend').addEventListener('click', () => {
        const txt = document.getElementById('txtMsg').value || '';

        if (txt.length) {
            session.publish("channel/foo", {msg: txt});
        }
    })

    session.subscribe("channel/foo", function (uri, payload) {
        log("Received message", payload.msg);
    });

    session.publish("channel/foo", {msg: "This is a message!"});

});

websocket.on("socket/disconnect", function (error) {
    log("Disconnected for " + error.reason + " with code " + error.code);
});
