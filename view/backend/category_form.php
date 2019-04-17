<?php $title = 'Administration des catégories - Mon premier blog !'; ?>
<?php ob_start(); ?>
    <body class="index-body">
        <div class="container-fluid">
            <?php require '././partials/backend/header.php'; ?>
            <div class="row my-3 index-content">
                <?php require '././partials/backend/nav.php'; ?>
                <section class="col-9">
                    <header class="pb-3">
                        <!-- Si $category existe, on affiche "Modifier" SINON on affiche "Ajouter" -->
                        <h4><?= (isset($_GET['category_id'])) ? 'Modifier une catégorie' : 'Ajouter une catégorie'; ?></h4>
                    </header>
                    <!-- on verifie si le tableau $warnings n'est pas vide pour afficher les massages a l'interieur d'une condition pour gagner en performance-->
                    <?php if (!empty($warnings)): ?>
                        <?php foreach($warnings as $key => $warning): ?>
                            <div class="bg-danger text-white p-2 mb-4">
                                <?= $warning; ?>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                    <!-- Si $category existe, chaque champ du formulaire sera pré-remplit avec les informations de la catégorie -->
                    <?php if (isset($_GET['category_id'])): ?>
                        <form action="index.php?page=admin_category_form&category_id=<?= $category['id']; ?>&action=edit" method="post" enctype="multipart/form-data">
                    <?php else: ?>
                        <form action="index.php?page=admin_category_form" method="post" enctype="multipart/form-data">
                    <?php endif; ?>
                        <div class="form-group">
                            <label for="name">Nom : <b class="text-danger">*</b></label>
                            <input class="form-control"  type="text" placeholder="Nom" name="name" id="name" value="<?= isset($category) ? htmlentities($category['name']) : '';?>"/>
                        </div>
                        <div class="form-group">
                            <label for="description">Description : </label>
                            <input class="form-control"  type="text" placeholder="Description" name="description" id="description" value="<?= isset($category) ? htmlentities($category['description']) : '';?>"/>
                        </div>
                        <div class="form-group">
                            <label for="image">Image :</label>
                            <input class="form-control" type="file" name="image" id="image" value="<?= $image; ; ?>"/>
                            <?php if (isset($_GET['category_id']) AND !empty($category['image'])): ?>
                                <img class="img-fluid py-4" src="../assets/img/<?= $category['image']; ?>" alt="" />
                                <input type="hidden" name="current-image" value="<?= $category['image'];?>" />
                            <?php endif;?>
                        </div>
                        <!-- Si $category existe, on ajoute un champ caché contenant l'id de la catégorie à modifier pour la requête UPDATE -->
                        <?php if (isset($_GET['category_id'])): ?>
                            <div class="form-group">
                                <input class="form-control" type="hidden" name="category_id" id="category_id" value="<?= $category['id'] ; ?>"/>
                            </div>
                        <?php endif;?>
                        <div class="text-right">
                            <!-- Si $category existe, on affiche un lien de mise à jour -->
<!--                            <p class="text-danger">* champs requis</p>-->
<!--                            <input class="btn btn-success" type="submit" name="update" value="--><?//= (isset($_GET['category_id'])) ? 'Mettre a jour' : 'Enregistrer' ;?><!--" />-->


                            <?php if (isset($_GET['category_id'])): ?>
                                <p class="text-danger">* champs requis</p>
                                <input class="btn btn-success" type="submit" name="update" value="Mettre a jour" />
                            <?php else: ?>
                                <p class="text-danger">* champs requis</p>
                                <input class="btn btn-success" type="submit" name="save" value="Enregistrer" />
                            <?php endif; ?>
                        </div>
                    </form>
                </section>
            </div>
        </div>
    </body>
<?php $content = ob_get_clean(); ?>
<?php require 'template.php'; ?>