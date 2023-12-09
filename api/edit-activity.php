<?php

require('../src/Api.php');

use Imdvlpr\Api;

$app = new Api();
echo $app->editActivity($_POST['id'], $_POST['title'], $_POST['desc'], $_POST['is_complete']);