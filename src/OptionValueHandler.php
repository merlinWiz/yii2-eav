<?php
/**
 * @author Alexey Samoylov <alexey.samoylov@gmail.com>
 */

namespace yarcode\eav;

/**
 * Class OptionValueHandler
 * @package yarcode\eav
 */
class OptionValueHandler extends ValueHandler
{
    /**
     * @inheritdoc
     */
    public function load()
    {
        $valueModel = $this->getValueModel();
        return $valueModel->optionId;
    }

    /**
     * @inheritdoc
     */
    public function save()
    {
        $dynamicModel = $this->attributeHandler->owner;
        $valueModel = $this->getValueModel();

        $valueModel->optionId =
            $dynamicModel->attributes[$this->attributeHandler->getAttributeName()];

        if (!$valueModel->save())
            throw new \Exception("Can't save value model");
    }

    /**
     * @inheritdoc
     */
    public function getTextValue()
    {
        return $this->getValueModel()->option->value;
    }
}