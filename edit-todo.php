<?php
    $filename = __DIR__ . "/data/todos.json";
    // on va protéger notre url
    $_GET = filter_input_array(INPUT_GET, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $id = $_GET['id'] ?? '';

    if($id) {
        $data = file_get_contents($filename);
        $todos = json_decode($data, true) ?? []; // on récupère notre tab associatif
        if (count($todos)) {
            $todoIndex = (int)array_search($id, array_column($todos, 'id'));
            // on stock l'inverse de la donnée dans done
            $todos[$todoIndex]['done'] = !$todos[$todoIndex]['done'];
            file_put_contents($filename, json_encode($todos));
        }

    }
    // On redirige vers la page principale
    header('Location: /');