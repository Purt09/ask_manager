<?php

use yii\helpers\Html;

?>
<?php foreach ($users as $user): ?>
    <div class="row bg-light p-3 shadow-sm mb-3">
        <div class="col-md-1 text-center">
            <img class="rounded-circle shadow" src="<?= ($photo_size == 0) ? $user['photo'] : $user['photo_medium'] ?>"
                 alt="<?= $user['username'] ?>">
        </div>
        <div class="col-md-6 ml-5 text-center">
            <b>
                <?= Html::a($user['username'], ['/user/profile/index', 'id' => $user['id']], ['class' => 'text-dark']) ?>
            </b>
            <hr>
            <div class="text-secondary">
                <?= $user['first_name'] ?>
                <?= $user['last_name'] ?>
            </div>

        </div>
        <div class="col-md-4">
            <?php foreach ($buttons as $button): ?>
                <?php if (!empty($button) && ($button['hide'] == false)): ?>
                    <?= Html::a($button['text'], [$button['url'], 'id' => $user['id'], 'redirect' => $button['redirect']], ['class' => $button['class']]) ?>
                <?php endif; ?>
            <?php endforeach; ?>
        </div>
    </div>
<?php endforeach; ?>
<?php if($button_bottom['status'] == true): ?>
<div class="text-center">
    <?= Html::a($button_bottom['text'], [$button_bottom['url'], 'redirect' => $button_bottom['redirect']], ['class' => $button_bottom['class']]) ?>
</div>
<?php endif; ?>