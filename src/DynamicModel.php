<?php
/**
 * @author Alexey Samoylov <alexey.samoylov@gmail.com>
 */

namespace yarcode\eav;

use yarcode\eav\models\Attribute;
use Yii;
use yii\base\DynamicModel as BaseDynamicModel;
use yii\db\ActiveRecord;
use yii\widgets\ActiveForm;

/**
 * Class DynamicModel
 * @package yarcode\eav
 */
class DynamicModel extends BaseDynamicModel
{
    /** @var string Class to use for storing data */
    public $valueClass;
    /** @var ActiveRecord */
    public $entityModel;
    /** @var AttributeHandler[] */
    public $handlers;
    /** @var ActiveForm */
    public $activeForm;
    /** @var string[] */
    private $attributeLabels = [];
    /** @var string  */

    public $fieldPrefix = 'eav';

    /** @var EavBehavior link to the parent behavior instance */
    private $behavior;

    /**
     * Constructor for creating form model from entity object
     *
     * @param array $params
     * @return static
     */
    public static function create($params)
    {
        $params['class'] = static::className();
        /** @var self $model */
        $model = Yii::createObject($params);

        foreach ($model->entityModel->getRelation($model->behavior->relationName)->all() as $attribute /** @var Attribute $attribute */) {
            $handler = AttributeHandler::load($model, $attribute);

            $key = $handler->getAttributeName();

            $model->defineAttribute($key, $handler->valueHandler->load());
            $model->defineAttributeLabel($key, $attribute->getAttribute('name'));

            if ($attribute->required) {
                $model->addRule($key, 'required');
            }

            if ($handler->valueHandler instanceof RawValueHandler) {
                $model->addRule($key, 'default', ['value' => $attribute->defaultValue]);
            }

            if ($handler->valueHandler instanceof OptionValueHandler) {
                $model->addRule($key, 'default', ['value' => $attribute->defaultOptionId]);
            }

            $model->handlers[$key] = $handler;
        }

        return $model;
    }

    /**
     * Defines label for dynamic attribute
     *
     * @param integer $attribute
     * @param string $label
     */
    public function defineAttributeLabel($attribute, $label)
    {
        $this->attributeLabels[$attribute] = $label;
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return $this->attributeLabels;
    }

    public function save($runValidation = true, $attributes = null)
    {
        if ($runValidation && !$this->validate($attributes)) {
            Yii::info('Dynamic model data were not save due to validation error.', __METHOD__);
            return false;
        }

        $db = $this->entityModel->getDb();

        $transaction = $db->beginTransaction();
        try {
            foreach ($this->handlers as $handler) {
                $handler->valueHandler->save();
            }
            $transaction->commit();
        } catch (\Exception $e) {
            $transaction->rollBack();
            throw $e;
        }

        return true;
    }
}