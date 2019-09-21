<?php if (isset($_SESSION['user'])): ?>
<div class="pos-f-t">
    <nav class="navbar navbar-dark bg-dark">
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarToggleExternalContent">
            <p>Menu</p>
        </button>
    </nav>
    <div class="collapse" id="navbarToggleExternalContent">
        <div class="bg-dark">
            <li class="p-2"><a href="index.php?page=home">Retour Site</a></li>
            <li class="p-2"><a href="index.php?page=admin">Dashboard</a></li>
            <li class="p-2"><a href="index.php?page=adminWrite">Ecrire un chapitre</a></li>
            <li class="p-2"><a href="index.php?page=adminChapters">Liste des Chapitres</a></li>
            <li class="p-2"><a href="index.php?page=admin&action=logout">Déconnexion</a></li>
        </div>
    </div>
</div>

<?php endif?>