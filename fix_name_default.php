<?php
require 'vendor/autoload.php';
require 'common/config/bootstrap.php';

$config = require 'common/config/console.php';
$app = new yii\console\Application($config);
$db = $app->db;

$db->createCommand("ALTER TABLE epaper_category MODIFY COLUMN `name` VARCHAR(255) DEFAULT ''")->execute();

echo "✅ FIXED: name field default value added!\n";
?>
