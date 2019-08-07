<?php
ob_start();
?>
<p>Livre - Copyright 2019<a href="https://marcalban.fr/"> - Fatellim</a>.</p>
<?php
$footer = ob_get_clean();
require 'template.php';
?>