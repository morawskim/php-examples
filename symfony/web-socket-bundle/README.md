## Info

The file `public/autobahn.min.js` is copy of `vendor/gos/web-socket-bundle/public/js/vendor/autobahn.min.js`.
We need to include this file before our js app.

We need to use old version - 0.8.2, because this is the last version which support WAMP v1 ([Changelog v0.9.0](https://github.com/crossbario/autobahn-js/blob/bd250753432a7bc61b7b7dae1df5fc70ddedcad6/doc/changelog.md#v090)).
Next versions have support only for version 2 of this protocol, but Ratchet currently support only v1.

[The WebSocket Protocol](https://datatracker.ietf.org/doc/html/rfc6455)

[Ratchet WampServer](http://socketo.me/docs/wamp)

[WAMP Implementations](https://wamp-proto.org/implementations.html)

## Usage

Call `make setup` to install dependencies.

Open `127.0.0.1` in your favourite webbrowser.
You should see very simple Websocket WAMP demo.
