<?php

use app\models\Libro;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\models\LibroSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Libros';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="libro-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Libro', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'pager' => [
    'class' => \yii\widgets\LinkPager::class,
    'options' => ['class' => 'pagination justify-content-center'],
    'linkOptions' => ['class' => 'page-link'],
    'activePageCssClass' => 'active',
    'disabledPageCssClass' => 'disabled', // <- esta clase aplica al elemento <li> si está deshabilitado
    'pageCssClass' => 'page-item',
    'prevPageLabel' => '«',
    'nextPageLabel' => '»',
    'disabledListItemSubTagOptions' => ['tag' => 'a', 'class' => 'page-link'], // <- agrega clase a botón deshabilitado
],
    'columns' => [
        ['class' => 'yii\grid\SerialColumn'],
        'id',
        'titulo',
        [
            'format' =>'html',
            'value' => function($data){ return Html::img($data->imagen, ['width' => '60px']); },
        ],
        [
            'class' => ActionColumn::class,
            'urlCreator' => function ($action, Libro $model, $key, $index, $column) {
                return Url::toRoute([$action, 'id' => $model->id]);
            },
        ],
    ],
]); ?>


</div>
