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
                <a class="btn btn-outline-light me-2" href="/main">Вернуться на главную</a>
                
            </div>
        </div>
    </nav>

    <div class="d-flex flex-column justify-content-center align-items-center vh-100">

        <div class="border p-3 bg-light rounded align-self-center" id="content">
            <!-- <span>Ваш токен:</span>
            <span id="access_token"></span> -->
            <input type="text" class="form-control" id="nickname_field" placeholder="Введите id пользователя">
            <div class="opacity-0" id="form_message">test</div>
            <div class="d-flex justify-content-end mb-1 mt-1">
                <button class="btn btn-primary custom-twitch-btn" id="connectToChat">Подлкючиться к чату</button>
            </div>
        </div>
        <div class="border p-3 bg-light rounded align-self-center mt-3" id="content">
            <div class="container mt-4">
                <div class="lead p-1">Чат юзера</div>
                <div id="chat-container" class="mb-3"></div>
            </div>
        </div>
    </div>
    <script src="../../src/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<script type="module">
    import { setCookie, getCookie } from "../../src/js/aboba.js";

    const client_id = "<?php echo $env["TWITCH_CLIENT_ID"]?>"
    const access_token = getCookie('access_token')
    const user_id = getCookie('user_id')
    const chatContainer = document.getElementById("chat-container");

    function connectToChat(nickname) {
        let socket = new WebSocket("wss://eventsub.wss.twitch.tv/ws");
        socket.onmessage = async function(event) {
            const url = 'https://api.twitch.tv/helix/eventsub/subscriptions'
            if(JSON.parse(event.data).payload.session != null) {
                const options = {
                method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Authorization': 'Bearer ' + access_token,
                        'Client-Id': client_id
                    },
                    body: JSON.stringify({
                        "type": "channel.chat.message",
                        "version": "1",
                        "condition": {
                            "broadcaster_user_id": "123364886",
                            "user_id": user_id
                        },
                        "transport": {
                            "method": "websocket",
                            "session_id": JSON.parse(event.data).payload.session.id
                        }
                    })
                };

            

                var response = await fetch(url, options)
                .then(response => {
                    return response
                })
                .catch(error => {
                    return error
                });
            } else {
                const msgevent = JSON.parse(event.data).payload.event

                const msgElement = document.createElement("div");
                msgElement.classList.add("chat-message");
                msgElement.innerHTML = `<strong>${msgevent.chatter_user_name}:</strong> ${msgevent.message.text}`;
                chatContainer.appendChild(msgElement);

                chatContainer.scrollTop = chatContainer.scrollHeight;
            }
        };
    }

    document.getElementById("connectToChat").addEventListener('click', (event) => {
        const user_id = document.getElementById('nickname_field').innerHTML
        
        connectToChat(user_id)
    })
</script>