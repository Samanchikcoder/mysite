<?php

// Имя поля с id сессии
define('CSRF_INPUT_NAME', 'SID');

/* Токен (GET) */

if (filter_has_var(INPUT_GET, CSRF_INPUT_NAME) && $_GET[CSRF_INPUT_NAME] != session_id()) {

    // Генерируем новый id сессии
    session_regenerate_id();
    // Удаляем токен
    unset($_GET[CSRF_INPUT_NAME]);

}

// Для ссылок (GET)
define('CSRF_GET_URL', CSRF_INPUT_NAME . '=' . session_id());

/* Проверка сессии */

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    if (!filter_has_var(INPUT_POST, CSRF_INPUT_NAME) || $_POST[CSRF_INPUT_NAME] != session_id()) {

        // Генерируем новый id сессии
        session_regenerate_id();
        // Удаляем зловредные данные
        unset($_POST);

    }

}

/* Работаем с буфером вывода */

function obCallback($buffer) {

    $doc = new DOMDocument;

    $doc->loadHTML($buffer);

    /* Обновление кэша стилей и скриптов */

    $links = $doc->getElementsByTagName('link'); // ищем стили

    foreach ($links as $element) {

        if (!$element->hasAttribute('href'))
            continue;

        $href = $element->getAttribute('href');

        $file = $_SERVER['DOCUMENT_ROOT'] . $href;

        if (!file_exists($file))
            continue;

        $mtime = filemtime($file);

        // Приписываем время последней модификации
        $element->setAttribute('href', $href . '?' . date('YmdHis', $mtime));

    }

    $scripts = $doc->getElementsByTagName('script'); // ищем скрипты

    foreach ($scripts as $element) {

        if (!$element->hasAttribute('src'))
            continue;

        $src = $element->getAttribute('src');

        $file = $_SERVER['DOCUMENT_ROOT'] . $src;

        if (!file_exists($file))
            continue;

        $mtime = filemtime($file);

        // Приписываем время последней модификации
        $element->setAttribute('src', $src . '?' . date('YmdHis', $mtime));

    }

    /* Защита от CSRF */

    $forms = $doc->getElementsByTagName('form'); // ищем формы

    foreach ($forms as $element) {

        // Узнаем метод передачи данных с формы
        $method = $element->getAttribute('method');
        $method = strtoupper($method);

        // Работаем только с POST-данными
        if ($method != 'POST')
            continue;

        /* Создаем поле */

        $newElement = $doc->createElement('input');

        $node = $element->appendChild($newElement);

        $node->setAttribute('type', 'hidden');
        $node->setAttribute('name', CSRF_INPUT_NAME);
        $node->setAttribute('value', session_id());

    }

    return $doc->saveHTML();

}

// Буферизация вывода
ob_start('obCallback');