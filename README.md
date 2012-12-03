This is little and simple, but ugly user control panel for [Subversion](http://en.wikipedia.org/wiki/Apache_Subversion). It uses svnserve built-in authentication and path-based authorization and does not work with other authentication methods.

All text, messages and necessary configuration is in config.json, content in other files do not need to be modified.

Installing
---------------------

1. Upload files to your public_html or wherever you want to run SVN control panel.
2. In config.json change paths to the files containing user and authorization information.
3. Now everything should be fine and you can happily start using SVN control panel.

Improving safety
---------------------

To improve safety I recommend to put htaccess auth in to the SVN control panel folder. You can use for example [Dynamic drive htaccess password generator](http://tools.dynamicdrive.com/password/) to generate the necessary files.

If you are wearing a tinfoil hat, you should probably rename config.json with [random string](https://www.grc.com/passwords.htm). If you do that, also remember to change configuration file name in index.php and functions.php.

You can also protect config.json file with htaccess. To do that, add following lines to your .htaccess file:
> <Files config.json>
> require valid-user
> </Files>

### Please note

After you started to use SVN control panel, you should not modify user and neither authorization files with text editor.

### License

This work is licensed under the Creative Commons Attribution-ShareAlike 3.0 Unported License. To view a copy of this license, visit [http://creativecommons.org/licenses/by-sa/3.0/](http://creativecommons.org/licenses/by-sa/3.0/).
