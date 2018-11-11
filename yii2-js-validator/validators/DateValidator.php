<?php

namespace app\validators;

class DateValidator extends \yii\validators\DateValidator
{
    public $enableClientValidation = true;

    public function clientValidateAttribute($model, $attribute, $view)
    {
        $options = $this->getClientOptions($model, $attribute);
        return 'dateValidator(value, messages, ' . json_encode($options, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) . ');';
    }

    public function getClientOptions($model, $attribute)
    {
        $options = [];
        $options['message'] = $this->formatMessage($this->message, [
            'attribute' => $model->getAttributeLabel($attribute),
        ]);

        return $options;
    }
}
