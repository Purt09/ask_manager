<?php
use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model app\modules\user\models\User */

$this->title = 'SEARCH';
$this->params['breadcrumbs'][] = $this->title;

?>

<h1>Результаты поиска:</h1>
<?php foreach ($users as $user): ?>
<?= Html::a($user['username'], '/user/profile', ['id' => $user['id']]) ?>
<hr>

<?php endforeach; ?>

