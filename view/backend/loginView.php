<div class="col-12 d-flex justify-content-center">
    <?php if (isset($errors) && !empty($errors)): ?>
    <div class="alert alert-danger col-12 col-md-12" role="alert">
        <?php foreach ($errors as $error): ?>
        <p><?=$error?></p>
        <?php endforeach?>
    </div>
    <?php endif?>
    <?php $title = 'Page de connexion'?>
    <form class="form-signin " method="POST" action="index.php?page=login&action=connexion">
        <h1 class="h3 mb-3 font-weight-normal">Mot de passe :</h1>
        <input type="password" id="inputPassword" class="form-control" name="password" placeholder="Mot de passe">
        <input class="btn btn-lg btn-primary btn-block" type='submit' name="connexion" placeholder="Connexion">
    </form>
</div>