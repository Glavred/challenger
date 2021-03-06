<?php
    use yii\helpers\Html;

?>
<div class="panel panel-default">
    <div class="panel-heading">
        Моя страница
    </div>
    <div class="panel-body">
        <?php if( !count($challenges) ): ?>
            <p class="text-muted text-center">
                У Вас нет новых заданий!
            </p>
            <p class="text-muted text-center">
                Не теряйте время, <a href="<?= \yii\helpers\Url::to(['subscription/all']) ?>">выберите себе курс</a>!
            </p>
        <?php else: ?>
            <h3>
                Новые задания
            </h3>
        <?php endif; ?>

        <?php foreach( $challenges as $challenge ): ?>
            <div class="panel panel-default">
                <div class="panel-heading">
                    <?= $challenge->name ?>
                </div>
                <div class="panel-body">
                    <p><?= $challenge->description ?></p>
                    <p>
                        <label>Курс:</label>
                        <?= $challenge->course->name ?>
                    </p>
                    <p>
                        <label>Заданий:</label>
                        <?= $challenge->getQuestionsCount() ?>
                    </p>

                    <div class="pull-right">
                        <a href="<?= \yii\helpers\Url::to(['challenge/start', 'id' => $challenge->id]) ?>" class="btn btn-success">Перейти к тесту</a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>