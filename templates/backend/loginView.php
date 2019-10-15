<div class="cotainer overflow-hidden">
    <div class="row justify-content-center ">
        <img src="img/admin.png" id="connexionAdmin" alt="image admin connexion ">
    </div>
    <div class="row justify-content-center ">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">Partie Administration</div>
                <div class="card-body">
                    <?php if (!empty($datas['errors'])): ?>
                    <div class="alert alert-danger col-12 col-md-12" role="alert">
                        <?php foreach ($datas['errors'] as $error): ?>
                        <p><?=$error?></p>
                        <?php endforeach?>
                    </div>
                    <?php endif?>
                    <form action="index.php?page=login&action=connexion&<?=$datas["session"]['token']?>" method="POST">
                        <div class="form-group row">
                            <label for="pseudo" class="col-md-4 col-form-label text-md-right">Pseudo</label>
                            <div class="col-md-6">
                                <input type="text" id="pseudo" class="form-control" name="pseudo" placeholder="Pseudo">
                                <div id="aidePseudo"></div>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">Mot de
                                passe</label>
                            <div class="col-md-6">
                                <input type="password" id="password" class="form-control" name="password"
                                    placeholder="Mot de passe">
                                <div id="aideMdp"></div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-6">
                                <input type="hidden" name="token" id="token" value="<?=$datas["session"]['token']?>" />
                            </div>
                        </div>
                        <div class="col-md-6 offset-md-4">
                            <button type="submit" class="btn btn-primary" name="connexion">
                                Connexion
                            </button>
                            <a class="btn btn-primary" href="index.php?page=home">Retour Accueil</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</div>