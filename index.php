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
                <form action="/" methode="POST" class="todo-form">
                    <input type=text>
                    <button class="btn btn-primary">Ajouter</button>
                </form>
                <div class="todo-form">
                    <div class="todo-list"></div>
                </div>
            </div>
        </div>
        <?php require_once 'includes/footer.php'?>
    </div>
    
    
</body>
</html>