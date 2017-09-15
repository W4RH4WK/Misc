# Style Directory
All static elements of the page are stored here. The content is created via
components (located at the `inc` folder).

### page.html
This file is the basic layout of your page. It mainly contains html code. All
needed libraries and such stuff is included. Change this file when you want to
change the page's structure

### style.css
Because structure and design should always be kept separated from each other.
The design related stuff goes into the `style.css` file.

### override.css
This CMS uses Bootstrap for some elements. The Bootstrap config itself is kept
default. If the default configuration does not fit your needs, place override
statements in the `override.css` file.

### nav.html
This file holds the page navigation. It's separated from the style for easier
editing.

### img folder
Page related gfx goes here.
