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
                        <a class="btn btn-sm nav-link m-2 " href="index.php?page=chapitres">Chapitres</a>
                    </li>
                </ul>
                <hr>
                <p>Admin</p>
                <?php if (isset($_SESSION['pass'])): ?>
                <a class="btn btn-sm btn-outline-secondary m-2" href="index.php?page=dashboard">Back Office</a>
                <a class="btn btn-sm btn-outline-secondary m-2" href="index.php?page=logout">Déconexion</a>
                <?php else: ?>
                <a class="btn btn-sm btn-outline-secondary m-2" href="index.php?page=login">Back Office</a>
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