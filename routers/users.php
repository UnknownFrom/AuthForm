<?php

require_once '../Database/app.php';
require_once '../assets/constants.php';

// Роутер
function route($method, $urlData, $formData) {

    // Получение информации о товаре
    // GET /users/{userId}
    if ($method === 'GET' && count($urlData) === 1) {
        // Получаем id пользователя
        $userId = $urlData[0];

        // Вытаскиваем пользователя из базы...
        //App::getResultFromDB(SELECT_USER,)

        // Выводим ответ клиенту
        echo json_encode(array(
            'method' => 'GET',
            'id' => $userId,
            'good' => 'phone',
            'price' => 10000
        ));

        return;
    }

    // Возвращаем ошибку
    header('HTTP/1.0 400 Bad Request');
    echo json_encode(array(
        'error' => 'Bad Request'
    ));

}