<?php $title = 'Profile - Mon premier blog !'; ?>
<?php ob_start(); ?>
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
                <form action="index.php?page=user_profile" method="post" class="p-4 row flex-column">
                    <h4 class="pb-4 col-sm-8 offset-sm-2">Mise à jour des informations utilisateur</h4>
                    <div class="form-group col-sm-8 offset-sm-2">
                        <label for="first_name">Prénom <b class="text-danger">*</b></label>
                        <input class="form-control" value="<?= isset($user) ? htmlentities($user['first_name']) : '' ;?>" type="text" placeholder="Prénom" name="first_name" id="first_name" />
                    </div>
                    <div class="form-group col-sm-8 offset-sm-2">
                        <label for="last_name">Nom de famille</label>
                        <input class="form-control" value="<?= isset($user) ? htmlentities($user['last_name']) : '' ;?>" type="text" placeholder="Nom de famille" name="last_name" id="last_name" />
                    </div>
                    <div class="form-group col-sm-8 offset-sm-2">
                        <label for="email">Email <b class="text-danger">*</b></label>
                        <input class="form-control" value="<?= isset($user) ? htmlentities($user['mail']) : '';?>" type="email" placeholder="Email" name="email" id="email" />
                    </div>
                    <div class="form-group col-sm-8 offset-sm-2">
                        <label for="password">Mot de passe (uniquement si vous souhaitez modifier votre mot de passe actuel)</label>
                        <input class="form-control" value="" type="password" placeholder="Mot de passe" name="password" id="password" />
                    </div>
                    <div class="form-group col-sm-8 offset-sm-2">
                        <label for="password_confirm">Confirmation du mot de passe (uniquement si vous souhaitez modifier votre mot de passe actuel)</label>
                        <input class="form-control" value="" type="password" placeholder="Confirmation du mot de passe" name="password_confirm" id="password_confirm" />
                    </div>
                    <div class="form-group col-sm-8 offset-sm-2">
                        <label for="bio">Biographie</label>
                        <textarea class="form-control" name="bio" id="bio" placeholder="Ta vie Ton oeuvre..."><?= isset($user) ? htmlentities($user['biography']) : '';?></textarea>
                    </div>
                    <div class="text-right col-sm-8 offset-sm-2">
                        <p class="text-danger">* champs requis</p>
                        <input class="btn btn-success" type="submit" name="update" value="Valider" />
                    </div>
                    <!-- Si $user existe, on ajoute un champ caché contenant l'id de l'utilisateur à modifier pour la requête UPDATE -->
                    <?php if(isset($user)): ?>
                        <input type="hidden" name="user_id" value="<?= $user['id']?>" />
                    <?php endif; ?>
                </form>
            </main>
        </div>
        <?php require '././partials/frontend/footer.php'; ?>
        <script src="https://code.jquery.com/jquery-3.1.1.slim.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.3.1/jquery.fancybox.min.js"></script>
        <script src="js/main.js"></script>
    </div>
</body>
<?php $content = ob_get_clean(); ?>
<?php require 'template.php'; ?>