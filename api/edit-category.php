<?php

require('../src/Api.php');

use Imdvlpr\Api;

$app = new Api();
echo $app->editCategory($_POST['category_id'], $_POST['category_name']);