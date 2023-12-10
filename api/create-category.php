<?php

require('../src/Api.php');

use Imdvlpr\Api;

$app = new Api();
echo $app->addCategory($_POST['category_name']);