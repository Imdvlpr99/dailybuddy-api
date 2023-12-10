<?php

require('../src/Api.php');

use Imdvlpr\Api;

$app = new Api();
echo $app->editCategory($_POST['id'], $_POST['category_name']);