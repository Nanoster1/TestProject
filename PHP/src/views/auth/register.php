<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Регистрация';
?>
<div class="site-signup">
    <h1>
        <?= Html::encode($this->title) ?>
    </h1>
    <p>Зарегайся скорее, кибер сторе ждёт:</p>
    <div class="row">
        <div class="col-lg-5">

            <?php $form = ActiveForm::begin(['id' => 'form-register']); ?>
            <?= $form->field($model, 'username')->textInput(['autofocus' => true])->label('Имя 🥸') ?>
            <?= $form->field($model, 'address')->textInput()->label('Адрес 🇷🇺') ?>
            <?= $form->field($model, 'password')->passwordInput()->label('Пароль 🤫') ?>
            <div class="form-group">
                <?= Html::submitButton('Зарегаться', ['class' => 'btn btn-primary', 'name' => 'signup-button']) ?>
            </div>
            <?php ActiveForm::end(); ?>

        </div>
    </div>
</div>