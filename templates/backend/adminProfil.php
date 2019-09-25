<div class="container">
    <div class="row">
        <div class="container">
            <h1>Mettre à jour le profil</h1>
            <?php if (!empty($datas['succes'])): ?>
            <div class="alert alert-success col-12 col-md-12" role="alert">
                <?php foreach ($datas['succes'] as $succes): ?>
                <p><?=$succes?></p>
                <?php endforeach?>
            </div>
            <?php endif?>
            <?php if (!empty($datas['errors'])): ?>
            <div class="alert alert-danger col-12 col-md-12" role="alert">
                <?php foreach ($datas['errors'] as $error): ?>
                <p><?=$error?></p>
                <?php endforeach?>
            </div>
            <?php endif?>
        </div>
        <div class="container">
            <form method="POST" action="index.php?page=adminProfil&action=update" id="tab">
                <p><label>Nouveau pseudo</label>
                    <input type="text" placeholder="pseudo" name="pseudo" class="input-xlarge"
                        value="<?=$datas['session']['user']?>"></p>
                <p><label>Nouveau mot de passe </label>
                    <input
                        type="<?=(isset($datas['get']['action']) && $datas['get']['action'] === 'demasquer') ? 'text' : 'password'?>"
                        placeholder="mot de passe" name="password" class="input-xlarge"
                        value="<?=$datas['session']['mdp']?>">
                    <?php if (isset($datas['get']['action']) && $datas['get']['action'] === 'demasquer'): ?>
                    <a href="index.php?page=adminProfil"><i class="fas fa-eye-slash"></i></a>
                    <?php else: ?>
                    <a href="index.php?page=adminProfil&action=demasquer"><i class="fas fa-eye"></i></a>
                    <?php endif?>
                </p>
                <p><label>Confirmer nouveau mot de passe </label>
                    <input
                        type="<?=(isset($datas['get']['action']) && $datas['get']['action'] === 'demasquer') ? 'text' : 'password'?>"
                        placeholder="confirmation mot de passe" name="passwordVerif" class="input-xlarge"
                        value="<?=$datas['session']['mdp']?>">
                    <?php if (isset($datas['get']['action']) && $datas['get']['action'] === 'demasquer'): ?>
                    <a href="index.php?page=adminProfil"><i class="fas fa-eye-slash"></i></a>
                    <?php else: ?>
                    <a href="index.php?page=adminProfil&action=demasquer"><i class="fas fa-eye"></i></a>
                    <?php endif?>
                </p>

                <div>
                    <button class="btn btn-primary">Mettre à jour</button>
                    <a href="index.php?page=adminChapters" class="btn btn-primary">Retour liste des
                        chapitres</a>
                </div>
            </form>
        </div>
    </div>
</div>