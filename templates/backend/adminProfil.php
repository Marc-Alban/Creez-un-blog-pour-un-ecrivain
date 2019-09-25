<div class="container">
    <div class="row">
        <h1>Mettre à jour le profile</h1>
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
        <div class="row">
            <form method="POST" action="index.php?page=adminProfil&action=update" id="tab">
                <label>Nouveau pseudo</label>
                <input type="text" placeholder="pseudo" name="pseudo" class="input-xlarge">
                <label>Nouveau mot de passe</label>
                <input type="password" placeholder="mot de passe" name="password" class="input-xlarge">
                <label>Confirmer nouveau mot de passe</label>
                <input type="password" placeholder="confirmation mot de passe" name="passwordVerif"
                    class="input-xlarge">
                <div>
                    <button class="btn btn-primary">Mettre à jour</button>
                    <a href="index.php?page=adminChapters" class="btn btn-primary">Retour liste des
                        chapitres</a>
                </div>
            </form>
        </div>
    </div>
</div>