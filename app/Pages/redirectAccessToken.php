<?php 
    $env = parse_ini_file(__DIR__.'/../../.env');
?>

<script>
    const params = new URLSearchParams(window.location.hash.substring(1))

    function setCookie(name,value,days) {
        console.log(1)
        var expires = "";
        if (days) {
            var date = new Date();
            date.setTime(date.getTime() + (days*24*60*60*1000));
            expires = "; expires=" + date.toUTCString();
        }
        document.cookie = name + "=" + (value || "")  + expires + "; path=/";
    }

    async function fetchUserId() {
        const response = await fetch('https://id.twitch.tv/oauth2/validate', {
            headers: {
                'Authorization': 'Bearer ' + params.get('access_token')
            },
            method: 'GET'
        }).then(resp => {
            return resp.json()
        }).catch(err => {
            console.log(err)
        })

        console.log('eblo')
        setCookie('user_id', response.user_id)
    }

    async function doThings() {
        setCookie('access_token', params.get('access_token'))
        await fetchUserId()

        window.location.replace(`${window.location.origin}/main`)
    }

    doThings()
   
</script>