<?php
/**
 * @var $this yii\web\View
 * @var $dataProvider yii\data\ActiveDataProvider
 * @var $entityName string
 */
use yii\helpers\Html;
use yii\grid\GridView;

$this->title = $entityName . ' Attributes';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="eav-attribute-index">
    <h1><?= Html::encode($this->title) ?></h1>
    <p>
        <?= Html::a('Create ' . $entityName . ' Attribute', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        'layout' => "{items}\n{pager}",
        'columns' => [
            'name',
            'defaultValue',
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{update} {delete}',
            ],
        ],
    ]); ?>
</div>
