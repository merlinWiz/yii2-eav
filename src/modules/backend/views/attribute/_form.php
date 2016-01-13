<?php
/**
 * @var $this yii\web\View
 * @var $model \yarcode\eav\models\Attribute
 * @var $form yii\widgets\ActiveForm
 * @var $typesQuery \yii\db\ActiveQuery
 */
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;

?>
<div class="eav-attribute-form">
    <?php $form = ActiveForm::begin(); ?>
    <?= $form->field($model, 'typeId')->dropDownList(ArrayHelper::map($typesQuery->all(), 'id', 'name')) ?>
    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update',
            ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>
