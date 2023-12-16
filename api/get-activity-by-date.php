<?php

require('../src/Api.php');

use Imdvlpr\Api;

$app = new Api();
echo $app->getActivityListByDate($_POST['date']);