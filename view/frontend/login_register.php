<?php $title = 'Login - Mon premier blog !'; ?>
<?php ob_start(); ?>
<!DOCTYPE html>
    <body class="article-body">
        <div class="container-fluid">
            <?php require '././partials/frontend/header.php'; ?>
            <div class="row my-3 article-content">
                <?php require('././partials/frontend/nav.php'); ?>
                <main class="col-9">
                    <!-- on verifie si le tableau $warnings n'est pas vide pour afficher les massages a l'interieur d'une condition pour gagner en performance-->
                    <?php if (!empty($warnings)): ?>
                        <?php foreach($warnings as $key => $warning): ?>
                            <div class="bg-danger text-white p-2 mb-4">
                                <?= $warning; ?>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                    <!-- par defaut le form login s'affiche et si post_register existe alors on affiche le form register et pas le login (la meme chose en en bas)-->
                    <ul class="nav nav-tabs justify-content-center nav-fill" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link <?php if (!isset($_POST['register'])): ?>active<?php endif; ?>" data-toggle="tab" href="#login" role="tab">Connexion</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?php if (isset($_POST['register'])): ?>active<?php endif; ?>" data-toggle="tab" href="#register" role="tab">Inscription</a>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane container-fluid <?php if (!isset($_POST['register'])): ?>active<?php endif; ?>" id="login" role="tabpanel">
                            <form action="index.php?page=login_register" method="post" class="p-4 row flex-column">
                                <h4 class="pb-4 col-sm-8 offset-sm-2">Connexion</h4>
                                <div class="form-group col-sm-8 offset-sm-2">
                                    <label for="email">Email <b class="text-danger">*</b></label>
                                    <input class="form-control" value="<?= !empty($warnings) ? $_POST['email'] : '' ?>" type="email" placeholder="Email" name="email" id="email" />
                                </div>
                                <div class="form-group col-sm-8 offset-sm-2">
                                    <label for="password">Mot de passe <b class="text-danger">*</b></label>
                                    <input class="form-control" value="" type="password" placeholder="Mot de passe" name="password" id="password" />
                                </div>
                                <div class="text-right col-sm-8 offset-sm-2">
                                    <p class="text-danger">* champs requis</p>
                                    <input class="btn btn-success" type="submit" name="login" value="Valider" />
                                </div>
                            </form>
                        </div>
                        <div class="tab-pane container-fluid <?php if (isset($_POST['register'])): ?>active<?php endif; ?>" id="register" role="tabpanel">
                            <form action="index.php?page=login_register" method="post" class="p-4 row flex-column">
                                <h4 class="pb-4 col-sm-8 offset-sm-2">Inscription</h4>
                                <div class="form-group col-sm-8 offset-sm-2">
                                    <label for="first_name">Prénom <b class="text-danger">*</b></label>
                                    <input class="form-control" value="<?= (!empty($warnings) AND isset($_POST['first_name'])) ? $_POST['first_name'] : '' ?>" type="text" placeholder="Prénom" name="first_name" id="first_name" />
                                </div>
                                <div class="form-group col-sm-8 offset-sm-2">
                                    <label for="last_name">Nom de famille</label>
                                    <input class="form-control" value="<?= (!empty($warnings) AND isset($_POST['last_name'])) ? $_POST['last_name'] : '' ?>" type="text" placeholder="Nom de famille" name="last_name" id="last_name" />
                                </div>
                                <div class="form-group col-sm-8 offset-sm-2">
                                    <label for="email">Email <b class="text-danger">*</b></label>
                                    <input class="form-control" value="<?= (!empty($warnings) AND isset($_POST['email'])) ? $_POST['email'] : '' ?>" type="email" placeholder="Email" name="email" id="email" />
                                </div>
                                <div class="form-group col-sm-8 offset-sm-2">
                                    <label for="password">Mot de passe <b class="text-danger">*</b></label>
                                    <input class="form-control" value="" type="password" placeholder="Mot de passe" name="password" id="password" />
                                </div>
                                <div class="form-group col-sm-8 offset-sm-2">
                                    <label for="password_confirm">Confirmation du mot de passe <b class="text-danger">*</b></label>
                                    <input class="form-control" value="" type="password" placeholder="Confirmation du mot de passe" name="password_confirm" id="password_confirm" />
                                </div>
                                <div class="form-group col-sm-8 offset-sm-2">
                                    <label for="bio">biography</label>
                                    <textarea class="form-control" name="bio" id="bio" placeholder="Ta vie Ton oeuvre..."><?= (!empty($warnings) AND isset($_POST['bio'])) ? $_POST['bio'] : '' ?></textarea>
                                </div>
                                <div class="text-right col-sm-8 offset-sm-2">
                                    <p class="text-danger">* champs requis</p>
                                    <input class="btn btn-success" type="submit" name="register" value="Valider" />
                                </div>
                            </form>
                        </div>
                    </div>
                </main>
            </div>
            <?php require '././partials/frontend/footer.php'; ?>
            <script src="https://code.jquery.com/jquery-3.1.1.slim.min.js"></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js"></script>
            <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js"></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.3.1/jquery.fancybox.min.js"></script>
            <script src="assets/js/main.js"></script>
        </div>
    </body>
<?php $content = ob_get_clean(); ?>
<?php require 'template.php'; ?>