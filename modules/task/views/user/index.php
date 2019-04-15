TASKS
<div class="container">
    <div class="row">
        <div class="col-sm-8">
            <div class="p-3 mb-2 bg-info text-white" >
                Активные задачи:
            </div>
            <?php foreach ($modelsactive as $model) : ?>
                <p>
                    - <?= $model->title ?>
                </p>
            <?php endforeach; ?>
        </div>

        <div class="col-sm-4">
            <div class="p-3 mb-2 bg-success text-white" >
                Выполненные:
            </div>
            <?php foreach ($modelspros as $model) : ?>
                <p>
                    - <?= $model->title ?>
                </p>
            <?php endforeach; ?>
        </div>
    </div>
</div>

