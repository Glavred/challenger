<?php
/**
 * @var \yii\data\ActiveDataProvider $dataProvider
 * @var \yii\web\View $this
 *
 */
?>

<div class="panel panel-default">
    <div class="panel-heading">
        Мои курсы
    </div>
    <div class="panel-body">
        <?php if( !$dataProvider->getCount() ): ?>
            <p class="text-muted text-center">
                Тут пока ничего нет, но это легко исправить!
            </p>
            <p class="text-muted text-center">
                Рекомендуем <a href="<?= \yii\helpers\Url::to(['subscription/all']) ?>">ознакомиться с доступными курсами</a>.
            </p>
        <?php endif; ?>

        <?php foreach( $dataProvider->getModels() as $course ): ?>
            <div class="panel panel-default">
                <div class="panel-heading">
                    <?= $course->name ?>
                </div>
                <div class="panel-body">
                    <p><?= $course->description ?></p>

                    <?php $progress = $course->getProgress( Yii::$app->user->id ) ?>
                    <div class="progress">
                        <div class="progress-bar progress-bar-info progress-bar-striped" role="progressbar" aria-valuenow="<?= $progress ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?= $progress ?>%">
                            <span class="sr-only"><?= $progress ?>% Complete</span>
                        </div>
                    </div>

                    <div class="pull-left">
                        <a href="<?= \yii\helpers\Url::to(['subscription/view', 'id' => $course->id]) ?>" class="btn btn-primary">Перейти к курсу</a>
                    </div>

                    <div class="pull-right">
                        <a href="<?= \yii\helpers\Url::to(['subscription/unsubscribe', 'id' => $course->id]) ?>" class="btn btn-default">Отписаться</a>
                    </div>
                </div>
            </div>
        <?php endforeach;?>
    </div>
</div>