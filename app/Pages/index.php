<?php
    $env = parse_ini_file(__DIR__.'/../../.env');
    $oauthUrl = urldecode("https://id.twitch.tv/oauth2/authorize?" . http_build_query([
        'response_type' => 'token',
        'client_id' => $env['TWITCH_CLIENT_ID'],
        'redirect_uri' => "http://localhost:8000/redirect_access_token",
        'scope' => 'user:read:chat'
    ]))
 
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
        <div class="border p-3 bg-light rounded">
            <a id="button-connect" class="btn btn-primary custom-twitch-btn" href='<?php echo $oauthUrl?>'>Авторизоваться через Twitch</a>
        </div> 
    </div>
    <script src="../../src/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<script>

</script>

