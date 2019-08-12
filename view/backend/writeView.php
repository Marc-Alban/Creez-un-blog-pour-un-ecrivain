<?php $title = 'Ecrire un chapitre'?>
<div class="container">
    <div class="row">
        <!-- <?php if (!empty($errors)): ?>
        <div class="alert alert-danger col-12 col-md-12" role="alert">
            <?php foreach ($errors as $error): ?>

            <p><?=$error?></p>
            <?php endforeach?>
        </div>
        <?php endif?> -->

        <form class="formT col-12" method="post" enctype="multipart/form-data">

            <!-- Text input-->
            <div class="form-group">
                <label class="col-md-4 control-label" for="chapitre_title">Titre</label>
                <div class="col-md-4">
                    <input id="chapitre_title" name="title" type="text" placeholder="titre"
                        class="form-control input-md">

                </div>
            </div>


            <!-- Textarea -->
            <div class="form-group">
                <label class=" col-12 col-md-12 control-label" for="source_description">Description</label>
                <div class=" col-12 col-md-12">
                    <textarea class="form-control" id="mytextarea" name="description"></textarea>
                </div>
            </div>

            <!-- File Button -->
            <div class="form-group">
                <label class=" col-md-4 control-label" for="source_image">Image</label>
                <div class="  col-md-4">
                    <input id="source_image" name="image" class="input-file" type="file">
                </div>
            </div>


            <!-- Select -->
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
                <button type="submit" name="submit" class="btn btn-primary">Envoyer</button>
            </div>
        </form>
    </div>
</div>