<?php
ob_start();
?>
<h2>Aie aie aie </h2>
<p>Page n'existe pas ...</p>
<?php
$content = ob_get_clean();
require 'template.php';
?>