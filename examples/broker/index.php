<?php
require_once __DIR__ . '/../../vendor/autoload.php';

if (isset($_GET['sso_error'])) {
    header("Location: error.php?sso_error=" . $_GET['sso_error'], true, 307);
    exit;
}

$broker = new Jasny\SSO\Broker(getenv('SSO_SERVER'), getenv('SSO_BROKER_ID'), getenv('SSO_BROKER_SECRET'));
$broker->attach(true);

$user = $broker->getUserInfo();

if (!$user) {
    header("Location: login.php", true, 307);
    exit;
}
?>
<!doctype html>
<html>
    <head>
        <title><?= $broker->broker ?> (Single Sign-On demo)</title>
        <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css" rel="stylesheet">        
    </head>
    <body>
        <div class="container">
            <h1><?= $broker->broker ?> <small>(Single Sign-On demo)</small></h1>
            <h3>Logged in</h3>

            <dl class="dl-horizontal">
                <?php foreach ($user as $key => $value) : ?>
                    <dt><?= $key ?></dt><dd><?= $value ?></dd>
                <?php endforeach; ?>
            </dl>
            
            <a id="logout" class="btn btn-default" href="login.php?logout=1">Logout</a>
        </div>
    </body>
</html>
