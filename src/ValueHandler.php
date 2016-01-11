<?php
/**
 * @author Alexey Samoylov <alexey.samoylov@gmail.com>
 */

namespace yarcode\eav;

use yarcode\eav\models\Value;
use yii\db\ActiveRecord;

/**
 * Class ValueHandler
 * @package yarcode\eav
 *
 * @property ActiveRecord $valueModel
 * @property string $textValue
 */
abstract class ValueHandler
{
    /** @var AttributeHandler */
    public $attributeHandler;

    /**
     * @return Value
     * @throws \Exception
     * @throws \yii\base\InvalidConfigException
     */
    public function getValueModel()
    {
        $dynamicModel = $this->attributeHandler->owner;
        /** @var ActiveRecord|string $valueClass */
        $valueClass = $dynamicModel->valueClass;

        /** @var Value $valueModel */
        $valueModel = $valueClass::findOne([
            'entityId' => $dynamicModel->entityModel->getPrimaryKey(),
            'attributeId' => $this->attributeHandler->attributeModel->getPrimaryKey(),
        ]);

        if (!$valueModel instanceof ActiveRecord) {
            /** @var Value $valueModel */
            $valueModel = new $valueClass;
            $valueModel->entityId = $dynamicModel->entityModel->getPrimaryKey();
            $valueModel->attributeId = $this->attributeHandler->attributeModel->getPrimaryKey();
            if (!$valueModel->save())
                throw new \Exception("Can't save value model");
        }

        return $valueModel;
    }

    abstract public function load();

    abstract public function save();

    /**
     * @return string
     */
    abstract public function getTextValue();
}