<?php $title = 'Administration - Mon premier blog !'; ?>
<?php ob_start(); ?>
<body class="index-body">
    <div class="container-fluid">
    <?php require '././partials/backend/header.php'; ?>
        <div class="row my-3 index-content">
            <?php require '././partials/backend/nav.php'; ?>
            <main class="col-9">

            </main>
        </div>
    </div>
</body>
<?php $content = ob_get_clean(); ?>
<?php require 'template.php'; ?>