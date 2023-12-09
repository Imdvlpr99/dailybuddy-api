<?php

require('../src/Api.php');

use Imdvlpr\Api;

$app = new Api();
echo $app->deleteActivity($_POST['id']);