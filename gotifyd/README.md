# GoTifyD

Daemon listening on UNIX socket, showing messages using notify-send.

## How to run

    $ go get https://github.com/W4RH4WK/gotifyd
    $ gotifyd $XDG_RUNTIME_DIR/gotifyd.sock

## How to use

    $ cat doc/examples/message.json | socat - UNIX-CONNECT:$XDG_RUNTIME_DIR/gotifyd.sock
