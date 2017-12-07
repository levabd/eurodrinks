<?php namespace Allatrack\Eurodrinks\Widgets;

use Backend\Classes\WidgetBase;

class Error extends WidgetBase {

    /**
     * @var string A unique alias to identify this widget.
     */
    protected $defaultAlias = 'errorsWidget';

    /**
     * @param $errors
     */
    public function setErrors($errors)
    {
        $this->vars['errors'] = $errors;
        return $this;
    }

    public function render()
    {
        return $this->makePartial('error');
    }

    public function getBlockHeight($error)
    {
        $error_len = strlen($error);
        $blockHeight = 20;

        if ($error_len>60){
            $blockHeight*= $error_len/60;
        }

        return $blockHeight;
    }
}