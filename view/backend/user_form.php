<?php $title = 'Administration des utilisateurs - Mon premier blog !'; ?>
<?php ob_start(); ?>
<body class="index-body">
    <div class="container-fluid">
        <?php require '././partials/backend/header.php'; ?>
        <div class="row my-3 index-content">
            <?php require '././partials/backend/nav.php'; ?>
            <section class="col-9">
                <header class="pb-3">
                    <!-- Si $user existe, on affiche "Modifier" SINON on affiche "Ajouter" -->
                    <h4><?= (isset($_GET['user_id'])) ? 'Modifier un utilisateur' : 'Ajouter un utilisateur' ;?></h4>
                </header>
                <!-- on verifie si le tableau $warnings n'est pas vide pour afficher les massages a l'interieur d'une condition pour gagner en performance-->
                <?php if (!empty($warnings)): ?>
                    <?php foreach($warnings as $key => $warning): ?>
                        <div class="bg-danger text-white p-2 mb-4">
                            <?= $warning; ?>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
                <!-- Si $user existe, chaque champ du formulaire sera pré-remplit avec les informations de l'utilisateur -->
                <form <?= (isset($_GET['user_id'])) ? 'action="index.php?page=admin_user_form&user_id='.$user['id'].'&action=edit"' : 'action="index.php?page=admin_user_form"'; echo 'method="post" enctype="multipart/form-data"';?>>
                    <div class="form-group">
                        <label for="first_name">Prénom : <b class="text-danger">*</b></label>
                        <input class="form-control"  type="text" placeholder="Prénom" name="first_name" id="first_name" value="<?= isset($user) ? htmlentities($user['first_name']) : '';?>"/>
                    </div>
                    <div class="form-group">
                        <label for="last_name">Nom de famille : <b class="text-danger">*</b></label>
                        <input class="form-control"  type="text" placeholder="Nom de famille" name="last_name" id="last_name" value="<?= isset($user) ? htmlentities($user['last_name']) : '';?>"/>
                    </div>
                    <div class="form-group">
                        <label for="email">Email : <b class="text-danger">*</b></label>
                        <input class="form-control"  type="email" placeholder="Email" name="email" id="email" value="<?= isset($user) ? htmlentities($user['mail']) : '';?>"/>
                    </div>
                    <div class="form-group">
                        <label for="password">Password : <b class="text-danger"><?= (isset($_GET['user_id'])) ? '(uniquement si vous souhaitez modifier votre mot de passe actuel)' : '*'; ?></b></label>
                        <input class="form-control" type="password" placeholder="Mot de passe" name="password" id="password" value=""/>
                    </div>
                    <div class="form-group">
                        <label for="bio">biography :</label>
                        <textarea class="form-control" name="bio" id="bio" placeholder="Sa vie son oeuvre..."><?= isset($user) ? htmlentities($user['biography']) : '';?></textarea>
                    </div>
                    <div class="form-group">
                        <label for="is_admin"> Admin ?</label>
                        <select class="form-control" name="is_admin" id="is_admin">
                            <?php if (isset($_GET['user_id'])): ?>
                                    <?php if ($user['is_admin'] == 0): ?>
                                        <option selected="selected" value="<?= $user['is_admin']; ?>" >Non</option>
                                        <option value="1">Oui</option>
                                    <?php else: ?>
                                        <option value="0" >Non</option>
                                        <option selected="selected" value="<?= $user['is_admin']; ?>">Oui</option>
                                    <?php endif;?>
                            <?php else: ?>
                                <option selected="selected" value="0" >Non</option>
                                <option value="1" >Oui</option>
                            <?php endif; ?>
                        </select>
                    </div>
                    <!-- Si $user_id existe, on ajoute un champ caché contenant l'id de l'utilisateur à modifier pour la requête UPDATE -->
                    <?php if (isset($_GET['user_id'])): ?>
                        <div class="form-group">
                            <input class="form-control" type="hidden" name="user_id" id="user_id" value="<?= $user['id']; ?>"/>
                        </div>
                    <?php endif;?>
                    <div class="text-right">
                        <!-- Si $user existe, on affiche un lien de mise à jour -->
                        <?php if (isset($_GET['user_id'])): ?>
                            <p class="text-danger">* champs requis</p>
                            <input class="btn btn-success" type="submit" name="update" value="Mettre a jour" />
                        <?php else: ?>
                            <p class="text-danger">* champs requis</p>
                            <input class="btn btn-success" type="submit" name="save" value="Enregistrer" />
                        <?php endif; ?>
                    </div>
                    <!-- Si $user existe, on ajoute un champ caché contenant l'id de l'utilisateur à modifier pour la requête UPDATE -->
                </form>
            </section>
        </div>
    </div>
</body>
<?php $content = ob_get_clean(); ?>
<?php require 'template.php'; ?>