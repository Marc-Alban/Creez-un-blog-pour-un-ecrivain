<div class="container">
    <div class="row">
        <?php
var_dump($errors);
if (!empty($errors)): ?>
        <div class="alert alert-danger col-12 col-md-12" role="alert">
            <?php foreach ($errors as $error): ?>
            <p><?=$error?></p>
            <?php endforeach?>
        </div>
        <?php endif?>

        <form class="formT col-12" action="index.php?page=adminWrite&action=newChapter" method="POST"
            enctype="multipart/form-data">

            <div class="form-group">
                <label class="col-md-4 control-label" for="chapitre_title">Titre</label>
                <div class="col-md-4">
                    <input id="chapitre_title" name="title" type="text" placeholder="titre"
                        class="form-control input-md">

                </div>
            </div>

            <div class="form-group">
                <label class=" col-12 col-md-12 control-label" for="source_description">Description</label>
                <div class=" col-12 col-md-12">
                    <textarea class="form-control" id="mytextarea" name="description"></textarea>
                </div>
            </div>

            <div class="form-group">
                <label class=" col-md-4 control-label" for="source_image">Image</label>
                <div class="  col-md-4">
                    <input id="source_image" name="image" class="input-file" type="file">
                </div>
            </div>

            <div class="form-group">
                <label class="col-md-4 control-label" for="chapitre_categories">Public</label>
                <div class="col-md-4">
                    <select id="chapitre_categories" name="public" class="form-control">
                        <option value="1">Oui</option>
                        <option value="2">Non</option>
                    </select>
                </div>
            </div>

            <div class="d-flex justify-content-center">
                <input type="submit" name="newChapter" class="btn btn-primary" placeholder="Envoyer">
            </div>
        </form>
    </div>
</div>