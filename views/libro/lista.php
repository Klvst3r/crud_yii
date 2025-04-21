<?php

use yii\helpers\Html;
use yii\widgets\LinkPager;

$this->title = 'Libros a la venta';
$this->params['breadcrumbs'][] = $this->title;

?>

<h1><?= Html::encode($this->title) ?></h1>

<div class="container">
    <div class="row">
        <?php foreach($libros as $libro): ?>
            <div class="col-md-4 mb-4">
                <div class="card h-100">
                    <?= Html::img($libro->imagen, ['class' => 'card-img-top', 'alt' => $libro->titulo]) ?>
                    <div class="card-body">
                        <h5 class="card-title"><?= Html::encode($libro->titulo) ?></h5>
                        <!-- Aquí puedes agregar más detalles del libro si quieres -->
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <div class="d-flex justify-content-center mt-4">
        <?= LinkPager::widget([
        'pagination' => $paginacion,
        'options' => ['class' => 'pagination'], // <ul class="pagination">
        'linkOptions' => ['class' => 'page-link'], // <a class="page-link">
        'activePageCssClass' => 'active', // <li class="page-item active">
        'disabledPageCssClass' => 'disabled', // <li class="page-item disabled">
        'pageCssClass' => 'page-item', // <li class="page-item">

        // Etiquetas para los botones anteriores y siguientes
        'prevPageLabel' => '«',
        'nextPageLabel' => '»',

        // Para que los elementos <li> tengan la clase 'page-item'
        'disabledListItemSubTagOptions' => ['tag' => 'a', 'class' => 'page-link'], // el <a> dentro del <li.disabled>
    ]) ?>

    </div>
</div>
