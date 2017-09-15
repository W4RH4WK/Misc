# Java Ranz

A dummy Java project to show off Makefiles.

    $ make
    $ make test
    $ ./javaranz.jar

## Manifest

This dummy project utilises two additional jars, located inside the `lib`
directory. We therefore have to setup a manifest for our target jar to
correctly set the class path.

If you want to add a new jar to the project, place it inside the `lib`
directory and append the class path entry in `Manifest.txt`. If you do not
require any additional jars, you can drop the manifest and simplify the
Makefile.

## Maven

Of course you could also use `maven`... or `ant`, or `gradle`...
