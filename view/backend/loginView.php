<div class="col-12 d-flex justify-content-center">
    <?php if (isset($errors) && !empty($errors)): ?>
    <div class="alert alert-danger col-12 col-md-12" role="alert">
        <?php foreach ($errors as $error): ?>
        <p><?=$error?></p>
        <?php endforeach?>
    </div>
    <?php endif?>
    <?php $title = 'Page de connexion'?>
    <form class="form-signin " method="post">
        <h1 class="h3 mb-3 font-weight-normal">Mot de passe :</h1>
        <label for="inputPassword" class="sr-only">Mot de passe</label>
        <input type="password" id="inputPassword" class="form-control" name="password" placeholder="Mot de passe">
        <button class="btn btn-lg btn-primary btn-block" name="submit" type="submit">Connexion</button>
    </form>
</div>