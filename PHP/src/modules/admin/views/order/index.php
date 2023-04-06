<?php
/*
 * Файл view-шаблона modules/admin/views/order/index.php
 */
use app\models\Order;
use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Заказы';
?>

<h1>
    <?= Html::encode($this->title) ?>
</h1>

<?=
    GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'id',
            'name',
            'email:email',
            'phone',
            'amount',
            [
                'attribute' => 'status',
                'value' => function ($data)
                {
                    switch ($data->status) {
                        case Order::STATUS_NEW:
                            return '<span class="text-danger">Новый</span>';
                        case Order::STATUS_PAYED:
                            return '<span class="text-warning">Оплачен</span>';
                        case Order::STATUS_BULD:
                            return '<span class="text-warning">Собирается</span>';
                        case Order::STATUS_DEL:
                            return '<span class="text-warning">Передан в доставку</span>';
                        case Order::STATUS_COM:
                            return '<span class="text-success">Выполнен</span>';
                        default: return 'Ошибка';
                    }
                },
                'format' => 'html'
            ],
            'created',
            'updated',
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]);
?>