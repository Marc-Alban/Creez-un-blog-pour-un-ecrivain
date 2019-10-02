<div class="container">
    <div class="row">

        <?php if (!empty($datas['errors'])): ?>
        <div class="alert alert-danger col-12 col-md-12" role="alert">
            <?php foreach ($datas['errors'] as $error): ?>
            <p><?=$error?></p>
            <?php endforeach?>
        </div>
        <?php endif?>

        <?php include "form.php";?>

        <a href="index.php?page=adminChapters" class="btn btn-primary m-4">Retour liste Chapitre</a>
    </div>
</div>