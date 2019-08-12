<?php
if (isset($_SESSION['pass'])) {
    ?>
<!-- -------- Navigation côté-------------- -->
<nav class=" nav navbar-nav side-nav">
    <ul>
        <li><a class="btn btn-sm nav-link m-2" href="index.php?page=home">Retour Site</a></li>
        <li><a class="btn btn-sm nav-link m-2" href="index.php?page=dashboard">Dashboard</a></li>
        <li><a class="btn btn-sm nav-link m-2" href="index.php?page=write">Ecrire un chapitre</a></li>
        <li><a class="btn btn-sm nav-link m-2" href="index.php?page=list">Modifier un chapitre</a></li>
    </ul>
</nav>
<?php }?>