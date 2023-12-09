<?php

require('../src/Api.php');

use Imdvlpr\Api;

$app = new Api();
echo $app->updateActivity($_POST['id'], $_POST['is_complete']);