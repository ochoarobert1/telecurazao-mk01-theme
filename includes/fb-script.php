<?php
if (!is_admin()){
    if (!$_SERVER['REMOTE_ADDR'] == '::1') {
?>
<script>
    window.fbAsyncInit = function() {
        FB.init({
            appId: '1148968338545559',
            xfbml: true,
            version: 'v2.10'
        });
        FB.AppEvents.logPageView();
    };

    (function(d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) {
            return;
        }
        js = d.createElement(s);
        js.id = id;
        js.src = "//connect.facebook.net/es_LA/sdk.js";
        fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));

</script>
<?php
    }
}
?>
