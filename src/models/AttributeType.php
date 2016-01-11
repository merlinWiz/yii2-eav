<?php
/**
 * @author Alexey Samoylov <alexey.samoylov@gmail.com>
 */
namespace yarcode\eav\models;

use yarcode\eav\StorageModel;
use Yii;

/**
 * This is the generic model class for the EAV attribute types table.
 *
 * @property integer $id
 * @property string $name
 * @property string $handlerClass
 */
abstract class AttributeType extends StorageModel
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'handlerClass'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'handlerClass' => 'Handler Class',
        ];
    }
}
