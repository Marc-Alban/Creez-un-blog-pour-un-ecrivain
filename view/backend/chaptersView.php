<div class="container">
    <div class="row">
        <?php $title = 'Liste des chapitres'?>
        <h2>Listes des Chapitres: </h2>
        <hr>
        <section class="blog-me pt-100 pb-100" id="blog">
            <div class="container">
                <div id="styleBloc">
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">Titre</th>
                                <th scope="col">Description</th>
                                <th scope="col">Date</th>
                                <th scope="col">Modifier</th>
                                <th scope="col">Supprimer</th>
                                <th scope="col">Visible</th>
                            </tr>
                        </thead>
                        <?php if (isset($datas['chapters'])): ?>
                        <?php foreach ($datas['chapters'] as $chapter): ?>
                        <tbody>

                            <tr>
                                <td><?=$chapter->title?></td>
                                <td><?=substr(nl2br($chapter->content), 0, 250)?></td>
                                <td><?=date("d/m/Y à H:i", strtotime($chapter->date_posts))?></td>
                                <td><a href="index.php?page=adminEdit&id=<?=$chapter->id?>" id="lien"><i
                                            class="far fa-edit"></i></a></td>
                                <td><a href="index.php?page=adminEdit&action=deleted&id=<?=$chapter->id?>"><i
                                            class="fas fa-trash"></i></a>
                                </td>
                                <td><?php echo ($chapter->posted == '0') ? '<span class="fas fa-lock"></span>' : '<i class="fas fa-eye"></i>' ?>
                                </td>
                            </tr>
                        </tbody>
                        <?php endforeach?>
                        <?php else:var_dump($datas['chapters']);?>
                        <?php endif;?>
                    </table>
                </div>
            </div>
        </section>
    </div>
</div>