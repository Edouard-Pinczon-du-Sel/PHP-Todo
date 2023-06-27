<?php
    const ERROR_REQUIRED = 'Veuillez renseigner une toto';
    const ERROR_TOO_SHORT = 'Veuillez entrer au moins 5 carctères';
    $error = '';

    // on verrifie qu'on est en méthode post
    if ($_SERVER['REQUEST_METHOD']=== 'POST') {
        // L'utilisateur à soumis un form
        $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        // si rien est entré on assigne '' à $todo
        $todo = $_POST['todo'] ?? '';

        if (!$todo) {
            $error = ERROR_REQUIRED;
        } elseif(strlen($todo) < 5) {
            $error = ERROR_TOO_SHORT;
        }
    }
?>



<!DOCTYPE html>
<html lang="fr">
<head>
    <?php 
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    require_once 'includes/head.php'?>
    <title>Todo</title>
</head>
<body>
    <div class="container">
        <?php require_once 'includes/header.php'?>
        <div class="content">
            <div class="todo-container">
                <h1>Ma Todo</h1>
                <form action="/" method="POST" class="todo-form">
                    <input name="todo" type=text>
                    <button class="btn btn-primary">Ajouter</button>
                </form>
                <?php // On affiche l'erreur?>
                <?php if($error): ?>
                    <p class="text-danger"><?= $error ?></p>
                <?php endif; ?>
                <div class="todo-form">
                    <div class="todo-list"></div>
                </div>
            </div>
        </div>
        <?php require_once 'includes/footer.php'?>
    </div>
    
    
</body>
</html>