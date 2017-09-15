# UIBK TeX Template

This repository holds my personal LaTeX templates for University stuff.

`short.tex` contains dedicated examples, other `.tex` files only contain lorem
ipsum.

## Acknowledgement

The [IT-Syndikat TeX Templates](https://github.com/ITSyndikat/its-tex-tpl) is
used as base for this one. The UIBK theme has been resued from internal
templates provided by the [IIS](https://iis.uibk.ac.at/) and
[CL](http://cl-informatik.uibk.ac.at/) Computer Science working groups.

## Building

Simply invoke `make` to build all examples:

    $ make

You can also specify which example you'd like to build:

    $ make book.pdf

## TikZ

TikZ figures can be included with `\input{gfx/picture.tikz}` but used libraries
of *all* figures have to be placed in your main `.tex` file because of strange
scoping.

## References

An example for references is provided with `book.tex`. Note that the
corresponding `.bbl` and `.blg` files have to be stated as dependencies in the
Makefile additional to the `.tex` file.

    book.pdf: book.tex book.bbl book.blg

## Requirements

- XeTeX
- Python Pygments
- Droid Font
- Ubuntu Font
