<?php

require('../src/Api.php');

use Imdvlpr\Api;

$app = new Api();
echo $app->addList($_POST['title'], $_POST['desc'], $_POST['date'], $_POST['time'], $_POST['category_id'], $_POST['is_complete']);