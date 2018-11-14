<?php

namespace app\validators;

use yii\validators\Validator;

class AjaxFakeValidator extends Validator
{
    public function init()
    {
        if ($this->message === null) {
            $this->message = \Yii::t('yii', 'The format of {attribute} is invalid.');
        }
    }

    public function clientValidateAttribute($model, $attribute, $view)
    {
        $options = $this->getClientOptions($model, $attribute);
        return 'fakeAsyncValidator(value, messages, ' . json_encode($options, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) . ', deferred);';
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
