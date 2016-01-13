<?php
/**
 * @var $this yii\web\View
 * @var $model \yarcode\eav\models\Attribute
 * @var $entityName string
 * @var $typesQuery \yii\db\ActiveQuery
 */
use yii\helpers\Html;

$this->title = $entityName . ' Attribute';
$this->params['breadcrumbs'][] = ['label' => $entityName . ' Attributes', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="eav-attribute-create">
    <h1><?= Html::encode($this->title) ?></h1>
    <?= $this->render('_form', [
        'model' => $model,
        'typesQuery' => $typesQuery,
    ]) ?>
</div>
