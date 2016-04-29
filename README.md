yii2-eav
========

EAV Dynamic Attributes for Yii2

## Configuration ##

Take a look at the *examples/m140423_034003_object.php* file and create your own data structure depending on the entity you are using.
I the most cases you'll need to change only the $entityName variable. For example: 

```
$entityName="user_profile";
```

Extend all models you'll find in the *yarcode\eav\models* namespace and place them under the unique namespace.
For example *common\models\user_profile_eav*.

Attach behavior to your model and define the *getEavAttributes* relation:

```php
/**
 * @inheritdoc
 */
public function behaviors()
{
    return [
        [
            'class' => \yarcode\eav\EavBehavior::className(),
            'valueClass' => \common\models\user_profile_eav\AttributeValue::className(),
        ],
    ];
}

/**
 * @return yii\db\ActiveQuery
 */
public function getEavAttributes()
{
    $query = \common\models\user_profile_eav\Attribute::find();
    $query->multiple = true;
    return $query;
}

