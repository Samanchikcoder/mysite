<?php

/* Фильтр данных */

function data_filter($str) {

    // Убираем пробелы с начала и конца строки
    $str = trim($str);

    // Фильтруем спец-символы
    $str = htmlspecialchars($str, ENT_QUOTES);

    return $str;

}

/* Фильтр многомерных массивов */

function mtd_array_filter($array, $callback, $keys = false) {

    if (is_array($array)) {

        $res = [];

        foreach ($array as $key => $value) {

            // Фильтруем ключи, если нужно
            if ($keys)
                $key = $callback($key);

            // Фильтруем дочерние массивы
            if (is_array($value))
                $res[$key] = mtd_array_filter($value, $callback);

            // Фильтруем значения
            else
                $res[$key] = $callback($value);

		}

        // Возвращаем готовый массив
		return $res;

	} else
		return false;

}

/* Фильтр всех входящих данных */

if (isset($_POST))
    $_POST = mtd_array_filter($_POST, 'data_filter');
if (isset($_GET))
    $_GET = mtd_array_filter($_GET, 'data_filter');
if (isset($_SESSION))
    $_SESSION = mtd_array_filter($_SESSION, 'data_filter');
if (isset($_COOKIE))
    $_COOKIE = mtd_array_filter($_COOKIE, 'data_filter');
if (isset($_SERVER))
    $_SERVER = mtd_array_filter($_SERVER, 'data_filter');