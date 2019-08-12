<?php

if (isset($user)) {

    ?>
<!-- Navigation principal -->
<nav class="navbar navbar-top">
    <ul class="nav navbar-right top-nav">
        <li><a href="#" data-placement="bottom" data-toggle="tooltip" href="#" data-original-title="Stats"><i
                    class="fa fa-bar-chart-o"></i>
            </a>
        </li>
    </ul>
</nav>
<!-- -------- Navigation côté-------------- -->
<nav class=" nav navbar-nav side-nav">
    <ul>
        <li><a class="btn btn-sm nav-link m-2" href="../index.php?page=home">Retour Site</a></li>
        <li><a class="btn btn-sm nav-link m-2" href="index.php?page=dashboard">Dashboard</a></li>
        <li><a class="btn btn-sm nav-link m-2" href="index.php?page=write">Ecrire un chapitre</a></li>
        <li><a class="btn btn-sm nav-link m-2" href="index.php?page=list">Modifier un chapitre</a></li>
    </ul>
</nav>

<?php }?>