<?php
// Direct Yii bootstrap
defined('YII_DEBUG') or define('YII_DEBUG', true);
defined('YII_ENV') or define('YII_ENV', 'dev');

require __DIR__ . '/vendor/autoload.php';
require __DIR__ . '/vendor/yiisoft/yii2/Yii.php';

$config = require __DIR__ . '/common/config/console.php';

$app = new yii\console\Application($config);
$db = $app->getDb();

try {
    $db->createCommand("ALTER TABLE epaper_category MODIFY COLUMN `name` VARCHAR(255) DEFAULT ''")->execute();
    echo "✅ FIXED: name field default value added!\n";
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
}
?>
