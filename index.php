<?php
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    const ERROR_REQUIRED = 'Veuillez renseigner une toto';
    const ERROR_TOO_SHORT = 'Veuillez entrer au moins 5 carctères';

    $filename = __DIR__ . "/data/todos.json";
    $error = '';
    $todo = '';
    $todos = [];

    //! PREMIER CHEMIN JSON VERS PHP // On entre décode pour pouvoir l'utiliser en tableau associatif php
    // on vérifie que le fichier existe
    if(file_exists($filename)) {
        // on récupère le json dans le fichier
        $data = file_get_contents($filename);
        // on le transforme en tableau associatif avec true pour le préciser (sinon objet par défaut)
        $todos = json_decode($data, true) ?? []; // sinon on met un tab vide
    }

    // on verifie qu'on est en méthode post
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // L'utilisateur à soumis un form
        $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        // Si rien est entré on assigne '' à $todo
        $todo = $_POST['todo'] ?? '';

        // gestion d'erreurs
        if (!$todo) {
            $error = ERROR_REQUIRED;
        } elseif(strlen($todo) < 5) {
            $error = ERROR_TOO_SHORT;
        }

        // On vérifie qu'il n'y a aucun erreur
        if (!$error) {
            // On ajoute une nouvelle todo $todo à l'intérieur du tableau associatif $todos qui contient toutes les todos
            $todos = [...$todos, [
                'name' => $todo,
                'done' => false,
                'id' => time()
            ]];
            //! CHEMIN INVERSE PHP VERS JSON // On sauvegarde
            file_put_contents($filename, json_encode($todos));
            // Empêche un nouvel envoi du form
            header('Location: /');

        }
    }
?>


<!DOCTYPE html>
<html lang="fr">
<head>
    <?php require_once 'includes/head.php'?>
    <title>Todo</title>
</head>
<body>
    <div class="container">
        <?php require_once 'includes/header.php'?>
        <div class="content">
            <div class="todo-container">
                <h1>Ma Todo</h1>
                <form action="/" method="POST" class="todo-form">
                    <input 
                        <?php if($error): ?>
                            value="<?=$todo ?>" 
                        <?php endif; ?>
                        name="todo" type=text>
                    <button class="btn btn-primary">Ajouter</button>
                </form>
                <?php // On affiche l'erreur?>
                <?php if($error): ?>
                    <p class="text-danger"><?= $error ?></p>
                <?php endif; ?>
                <ul class="todo-list">
                    <?php // Pour chaque todo du tableau $todos
                        foreach($todos as $t):  ?>
                        <li class="todo-item <?= $t['done'] ? 'low-opacity' : ''?>">
                            <span class="todo-name <?= $t['done'] ? 'todo-done' : ''?>"><?= $t['name'] ?></span>
                            <a href="/edit-todo.php?id=<?=$t['id']?>">
                                <button class="btn btn-primary btn-small"><?= $t['done'] ? 'Annuler' : 'Valider' ?></button>
                            </a>
                            <a href="/remove-todo.php?id=<?=$t['id']?>">
                                <button class="btn btn-small <?= $t['done'] === true ? 'btn-archive' : 'btn-danger' ?>">
                                    <?= $t['done'] === true ? 'Archiver' : 'Supprimer' ?>
                                </button>
                            </a>
                        </li>
                    <?php endforeach; ?>

                        
                    
                       
                </ul>
                <div class="todo-form">
                    <div class="todo-list"></div>
                </div>
            </div>
        </div>
        <?php require_once 'includes/footer.php'?>
    </div>
    
    
</body>
</html>