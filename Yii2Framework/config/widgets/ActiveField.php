<?php
namespace app\config\widgets;
use Yii;
use yii\helpers\Url;
use yii\helpers\Html;
use yii\helpers\BaseHtml;
use yii\helpers\ArrayHelper;
use dosamigos\ckeditor\CKEditor;
use yii\captcha\Captcha;
use unclead\multipleinput\MultipleInput;
use kartik\select2\Select2;
class ActiveField extends \yii\bootstrap\ActiveField {
    protected function createLayoutConfig($instanceConfig) {
        $config                          = parent::createLayoutConfig($instanceConfig);
        $config['inputOptions']['class'] = 'form-control input-sm';
        return $config;
    }
    public function fileInput($options = []) {
        if (!isset($this->form->options['enctype'])) {
            $this->form->options['enctype'] = 'multipart/form-data';
        }
        if ($this->form->validationStateOn === ActiveForm::VALIDATION_STATE_ON_INPUT) {
            $this->addErrorClassIfNeeded($options);
        }
        $this->addAriaAttributes($options);
        $this->adjustLabelFor($options);
        $this->parts['{input}'] = Html::activeFileInput($this->model, $this->attribute, $options);
        return $this;
    }
    public function dropDownList($items, $options = []) {
        $options['prompt'] = Yii::t('app', 'Please Select');
        if ($this->attribute == 'province_id' && property_exists($this->model, 'city_id')) {
            $cityId              = '#' . BaseHtml::getInputId($this->model, 'city_id');
            $content             = Yii::t('app', 'Please Select');
            $url                 = Url::to(['/geo/cities-services/get-cities']);
            $options['onchange'] = "LoadCities(this, '$cityId', '$content', '$url');";
        }
        return parent::dropDownList($items, $options);
    }
    public function plusAdad($model, $name, $myid) {
        return $this->widget(MultipleInput::className(), [
                    'id'                  => $myid,
                    'attributeOptions'    => ['type' => 'number'],
                    'enableGuessTitle'    => true,
                    'min'                 => 0,
                    'addButtonPosition'   => MultipleInput::POS_HEADER, // show add button in the header
                    'columns'             => [
                            [
                            'name'    => $name,
                            'title'   => '<label class="control-label">' . $model->getAttributeLabel($name) . '</label>',
                            'options' => [
                                'class' => 'number',
                                'dir'   => 'ltr',
                                'type'  => 'number'
                            ],
                        ]
                    ],
                    'addButtonOptions'    => [
                        'class' => 'btn btn-sm btn-default',
                        'style' => 'padding: 9px 9px 4px;',
                    ],
                    'removeButtonOptions' => [
                        'class' => 'btn btn-sm btn-danger pull-left',
                        'style' => 'padding: 9px 9px 4px;',
                    ]
                ])->label(false);
    }
    public function adad($model, $name, $options) {
        $sourceName  = 'attribute_' . $options['options']['source-id2'];
        $sourceValue = [];
        if ($model->$sourceName && is_array($model->$sourceName)) {
            $sourceValue = $model->$sourceName;
        }
        $fid    = $model->formName();
        $label  = $model->getAttributeLabel($name);
        $id     = $this->getInputId();
        $error  = $model->getFirstError($name);
        $value  = $model->$name;
        $inputs = '';
        if (is_array($value)) {
            foreach ($value as $index => $row) {
                $v      = (isset($sourceValue[$index]) ? $sourceValue[$index] : '');
                $inputs .= '
                    <div class="form-group" style="margin-bottom: 10px;">
                        <div class="input-group">
                            <span class="input-group-addon">' . $v . '</span>
                            <input type="number" class="form-control number" name="' . $fid . '[' . $name . '][' . $index . ']" dir="ltr" value="' . $row . '"/>
                        </div>
                    </div>
                ';
            }
        }
        $hasError = $error ? 'has-error' : '';
        return <<<A
        <div class="form-group field-$id required $hasError" name="$name" source-id="{$options['options']['source-id']}" source-id2="{$options['options']['source-id2']}" source-value="{$options['options']['source-value']}" style="{$options['options']['style']}">
            <label class="control-label" for="$id" style="margin-top: 19px;">$label</label>
            <hr style="margin-top: 0px;border-top: 1px solid #DDD;margin-bottom: 6px;"/>
            $inputs
            <p class="help-block help-block-error">$error</p>
        </div>
A;
//        return $this->textInput(['dir' => 'ltr', 'class' => 'form-control number']);
    }
    public function ckeditor() {
        return $this->widget(CKEditor::className(), [
                    'options'       => ['rows' => 6],
                    'clientOptions' => [
                        'language'      => 'fa',
                        'extraPlugins'  => 'bidi',
                        'toolbarGroups' => [
                                ['name' => 'bidi']
                        ]
                    ],
                    'preset'        => 'basic',
        ]);
    }
    public function captcha($options = []) {
        $options = ArrayHelper::merge($options, ['class' => 'form-control']);
        return $this->widget(Captcha::classname(), [
                    'options'       => $options,
                    'template'      => '
                <div class="row">
                    <div class="col-lg-7 col-md-6 form-group">{input}</div>
                    <div class="col-lg-5 col-md-6"><a class="refreshcaptcha" href="#">{image}</a></div>
                </div>
            ',
                    'captchaAction' => '/users/auth/captcha'
        ]);
    }
    public function select2($data) {
        return $this->widget(Select2::classname(), [
            'data' => $data,
            'options' => ['placeholder' => Yii::t('app', 'Please Select')],
            'pluginOptions' => [
                'dir' => 'rtl',
                'allowClear' => true
            ],
        ]);
    }
}