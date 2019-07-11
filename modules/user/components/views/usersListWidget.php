<?php
use yii\helpers\Html;
?>
<?php foreach ($users as $user): ?>
    <div class="row bg-light p-3 shadow-sm mb-3" >
        <div class="col-md-1">
            <img class="rounded-circle shadow" src="<?= ($photo_size == 0) ? $user['photo'] : $user['photo_medium'] ?>" alt="<?= $user['username'] ?>">
        </div>
        <div class="col-md-5 ml-5 ">
            <b>
            <?= $user['username'] ?>
            </b>
            <hr>
            <div class="text-secondary">
            <?= $user['first_name'] ?>
            <?= $user['last_name'] ?>
            </div>

        </div>
        <div class="col-md-2">
            <?php if($button === true): ?>
                <?= Html::a('Добавить',['/user/default/add-request', 'id' => $user['id'], 'redirect' => 'profile/search'], ['class' => 'btn btn-success'])?>
            <?php endif; ?>
        </div>
    </div>
<?php endforeach; ?>
