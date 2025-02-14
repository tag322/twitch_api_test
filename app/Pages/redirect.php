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
    <div class="d-flex justify-content-center align-items-center vh-100">
        <div class="border p-3 bg-light rounded align-self-center">
            <span>Ваш токен:</span>
            <span id="access_token"></span>
            <input type="text" class="form-control mt-4" id="nickname_field" placeholder="Введите отображаемое имя">
            <div class="opacity-0" id="form_message">test</div>
            <div class="d-flex justify-content-center mt-1 mb-4">
                <button class="btn btn-primary custom-twitch-btn" id="fetchData">Получить данные о пользователе</button>
            </div>
            <div id="json-container" class="json-container">
                
            </div>
        </div> 
    </div>
    <script src="../../src/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<script>
    const params = new URLSearchParams(window.location.hash.substring(1))
    document.getElementById("access_token").innerHTML = params.get('access_token')

    function formatJson(data) {
        const container = document.getElementById('json-container');
        let html = '<pre>{<br>';
        Object.keys(data).forEach(key => {
            const value = data[key];
            if (typeof value === 'string' && value.length > 50) {
                html += `  <span class="json-key">"${key}":</span> <span class="json-value">"${value}"</span>,<br>`;
            } else {
                html += `  <span class="json-key">"${key}":</span> <span class="json-value">${JSON.stringify(value)}</span>,<br>`;
            }
        });
        html += '}</pre>';
        container.innerHTML = html;
    }

    function storeDataInDB(json) {
        const url = "<?php echo $env["APP_URL"]?>"

        fetch(url + '/api/store_user_info', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(json)
        }).then(response => {

        })
    }

    document.getElementById('fetchData').addEventListener('click', async function() {
        const nickname = document.getElementById('nickname_field').value

        console.log("<?php echo $env['APP_URL'] ?>")
 
        if(nickname == "") {
            document.getElementById('form_message').innerHTML = "Заполните это поле"
            document.getElementById('form_message').classList.toggle('opacity-0')
            document.getElementById('form_message').classList.toggle('text-danger')
            document.getElementById('nickname_field').classList.toggle('border-danger')
            return
        } else {
            document.getElementById('form_message').innerHTML = "Заполните это поле"
            document.getElementById('form_message').classList.add('opacity-0')
            document.getElementById('form_message').classList.remove('text-danger')
            document.getElementById('nickname_field').classList.remove('border-danger')
        }
    
        const url = 'https://api.twitch.tv/helix/users?' + new URLSearchParams({
            login: nickname,
        }) ;

        const options = {
            method: 'GET',
            headers: {
                'Content-Type': 'application/json',
                'Authorization': 'Bearer ' + params.get('access_token'),
                'Client-Id': 'woux9nne4qrs1bboosfsp00xjm0nyk'
            },
        };

        var response = await fetch(url, options)
        .then(response => {
            return response
        })
        .catch(error => {
            return error
        });

        data = (await response.json()).data[0]

        formatJson(data);
        storeDataInDB(data)
    })
</script>