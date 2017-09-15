# HPGL Transform [BETA]

## About

This script enables you to easily apply linear transformations to a HPGL file.
A HPGL file usually looks like this:

    IN;SP1;PU0,0;PD100,0,100,100,0,100,0,0;PU0,0;

The script either reads this from `stdin` and writes the transformed content to
`stdout` or edits stated files **inplace**. Transformations are applied in the
given order.

## Examples

Rotate, move right and scale HPGL file:

    $ ./HPGLtrans -R 90 -Tx 100 -S 2 file.hpgl

Rotate, move right and scale HPGL file, save as new file:

    $ ./HPGLtrans -R 90 -Tx 100 -S 2 < file.hpgl > file_new.hpgl

Move down, rotate, move up and send to printer:

    $ cat file.hpgl | ./HPGLtrans -Ty -100 -R 60 -Ty 100 > /dev/usb/lp0

## License

    "THE BEER-WARE LICENSE" (Revision 42):

    Alex "W4RH4WK" Hirsch created this project. As long as you retain this
    notice you can do whatever you want with this stuff. If we meet some day,
    and you think this stuff is worth it, you can buy me a beer in return.

    This project is distributed in the hope that it will be useful, but WITHOUT
    ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or
    FITNESS FOR A PARTICULAR PURPOSE.
