# Inspect

This utility outputs meta information about the given file. It can be used in
combination with other tools, like [fzf].

    $ fzf --preview 'inspect {}'

[fzf]: <https://github.com/junegunn/fzf>

## Install

Simply copy `inspect` into your path. For instance `$HOME/bin` or
`$HOME/.local/bin`.

## Security Notice

This script will invoke other tools (like `identify` from [ImageMagick]) to get
more detailed file information. Thus it is not recommended to run this script
on untrusted files.

[ImageMagick]: <https://www.imagemagick.org/>
