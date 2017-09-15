# Phoenix Template

<p align="center">
    <img src="data/gallery/preview.png" width="500" />
</p>

### Description
This projects aims to be a starting template for simple web pages. It's built
on top of the silex micro framework. Even though a file manager with editor is
provided, the recommended way of alerting content would be handling the files
directly or via sftp. This encourages you to use your favorite editor.

### Used Components
 - [Bootstrap](http://twitter.github.com/bootstrap/)
 - [CKEditor](http://ckeditor.com/)
 - [Flowplayer](http://flowplayer.org/)
 - [Font Awesome](http://fortawesome.github.com/Font-Awesome/)
 - [Jquery](http://jquery.com/)
 - [Lightbox](http://lokeshdhakar.com/projects/lightbox2/)
 - [Markdown](http://michelf.ca/projects/php-markdown/)

### Features
 - **no database needed --> everything is a file**
 - static pages with HTML or Markdown
 - blog working out of the box
 - gallery with automatic thumbnail creation
 - file section
 - user authentication
 - handcrafted file manager
 - WYSIWYG editor

### Installation
[Composer](http://getcomposer.org/) is used for the installation so process.
The `composer.json` file is part of the project just run composer.

    $ git clone git://github.com/W4RH4WK/Phoenix-Tpl.git ptpl
    $ cd ptpl
    $ composer install

Change the url inside the `app/app.php`.

    $app['url'] = 'http://example.org/';

Point your web server to the `web` directory.

### Installation (no `web` directory)
Simply run

    $ bash utils/web_to_root.sh
    $ git add --all
    $ git commit -m 'move web to root'

and point your web server to the root directory of this project.

I already created a default user with username `root` and password `toor`.
Please create a new user and remove this one *before* you deploy the system.

### How to add content
All content should be kept inside the `data` folder. Some example content has
been created for you. If you encounter problems do not hesitate looking at the
code, I tried keeping it clean and simple.

You can find the implementation code inside the `app` directory.

### How to customize the page
The two main files you want to look at are `tpl/layout.html.twig` and
`web/assets/default.css`. If you want to change the look of a specific
component checkout the corresponding template inside the `tpl` folder.

My logo is used as placeholder in this project, just replace the files inside
`web/assets/gfx`.

Another way to easily customize the web page would be creating your own version
of bootstrap and replace the content inside `web/assets/bootstrap`.

The default route is set at the bottom of `app/app.php`.

### How to add a user
All users are stored inside `data/passwd.json`. In order to add a user, use the
script inside the `utils` folder.

    $ php utils/usermgmt.php warhawk

The first parameter is the username, it will prompt for a password.

If you need additional user parameters (like email address, etc.) just add them
to the `passwd.json` file. They should be available via
`$app['user']->get_user()['email']`.

### How to login / logout
`http://example.org/user/login`. Upon browsing to `user/login` a login box is
shown. After entering valid credentials two new buttons should appear on the
right side of the navigation. One of them is the logout button.

I already created a default user with username `root` and password `toor`.
Please create a new user and remove this one *before* you deploy the system.

### Disable login
You can disable the login completly by deleting `data/passwd.json`.  This
disables the login mechanism completely. (`http://example.org/user/login` will
still be accessible)

### License
    Copyright (c) 2013 Alex W4RH4WK Hirsch

    This program is free software: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 3 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program.  If not, see <http://www.gnu.org/licenses/>.
