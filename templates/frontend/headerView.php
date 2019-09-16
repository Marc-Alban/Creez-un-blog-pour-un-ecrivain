<div class="container">
    <header class="blog-header py-3">
        <div class="row justify-content-between align-items-center">
            <div class="container">
                <a href="index.php?page=home">
                    <div class="title">Jean Forteroche</div>
                </a>
                <div class="subtitle">Auteur, Ecrivain</div>
            </div>
            <nav class="animate ">
                <ul>
                    <li>
                        <a class="btn btn-sm nav-link m-2" href="index.php?page=home">Accueil</a>
                    </li>
                    <li>
                        <a class="btn btn-sm nav-link m-2 " href="index.php?page=chapters">Chapitres</a>
                    </li>
                </ul>
                <hr>
                <p>Admin</p>
                <?php if (isset($_SESSION['password'])): ?>
                <a class="btn btn-sm btn-outline-secondary m-2" href="index.php?page=admin">Back Office</a>
                <a class="btn btn-sm btn-outline-secondary m-2" href="index.php?page=logout">Déconexion</a>
                <?php else: ?>
                <a class="btn btn-sm btn-outline-secondary m-2" href="index.php?page=login&action=connexion">Back
                    Office</a>
                <?php endif?>
            </nav>
            <div class="nav-controller">
                <span class="controller-open">Menu</span>
                <span class="controller-close">X</span>
            </div>
        </div>
</div>
</header>
</div>