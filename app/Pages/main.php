<?php
    $env = parse_ini_file(__DIR__.'/../../.env');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Twitch Api Test</title>

    <link href="../../src/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="../../src/customCss/styles.css" rel="stylesheet">

</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Twitch API Test</a>
            <div class="d-flex">
                <!-- <button class="btn btn-outline-light me-2" id="">Прочитать чат</button> -->
                <!-- <button class="btn btn-outline-light" id="">Выйти</button> -->
            </div>
        </div>
    </nav>

    <div class="d-flex justify-content-center align-items-center vh-100">
        <div class="border p-3 bg-light rounded align-self-center">   
            <div class="d-flex flex-column justify-content-center ">
                <a class="btn btn-primary custom-twitch-btn mb-3" href="/retrieve_user_info">Получить данные о пользователе</a>
                <a class="btn btn-primary custom-twitch-btn" href="/retrieve_chat">Получить сообщения из чата</a>
            </div>
        </div> 
    </div>
    <script src="../../src/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<script type="module">
    import { setCookie, getCookie } from "../../src/js/aboba.js";

    
    
</script>