<?php
/**
 * @author Alexey Samoylov <alexey.samoylov@gmail.com>
 */

namespace yarcode\eav;

use Yii;
use yii\base\InvalidParamException;
use yii\base\Widget;
use yii\db\ActiveRecord;

/**
 * Class AttributeHandler
 * @package yarcode\eav
 */
class AttributeHandler extends Widget
{
    const VALUE_HANDLER_CLASS = '\yarcode\eav\RawValueHandler';
    /** @var DynamicModel */
    public $owner;
    /** @var ValueHandler */
    public $valueHandler;
    /** @var ActiveRecord */
    public $attributeModel;

    /**
     * @param DynamicModel $owner
     * @param ActiveRecord $attributeModel
     * @return AttributeHandler
     * @throws \yii\base\InvalidConfigException
     */
    public static function load($owner, $attributeModel)
    {
        if (!class_exists($class = $attributeModel->type->handlerClass))
            throw new InvalidParamException('Unknown class: ' . $class);

        $handler = Yii::createObject([
            'class' => $class,
            'owner' => $owner,
            'attributeModel' => $attributeModel
        ]);
        $handler->init();

        return $handler;
    }

    /**
     * @inheritdoc
     */
    public function init()
    {
        $this->valueHandler = Yii::createObject([
            'class' => static::VALUE_HANDLER_CLASS,
            'attributeHandler' => $this,
        ]);
    }

    /**
     * @return string
     */
    public function getAttributeName()
    {
        return $this->owner->fieldPrefix . strval($this->attributeModel->getPrimaryKey());
    }

    public function getOptions()
    {
        $result = [];
        foreach ($this->attributeModel->options as $option)
            $result[] = $option->getPrimaryKey();
        return $result;
    }
}