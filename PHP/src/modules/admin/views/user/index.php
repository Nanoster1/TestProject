<?php

use app\modules\admin\models\User;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Пользователи';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">

    <h1>
        <?= Html::encode($this->title) ?>
    </h1>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'username',
            'password',
            'authKey',
            'accessToken',
            //'address',
            //'role',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, User $model, $key, $index, $column)
                    {
                        return Url::toRoute([$action, 'id' => $model->id]);
                    }
            ],
        ],
    ]); ?>


</div>