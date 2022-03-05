<?php

namespace App\Helper;

use Carbon\Carbon;
use Form;

/**
 * to create dynamic fields for modules
 */

class Field
{
    /**
     * @param $name
     * @param $label
     * @param null $value
     * @return string
     */
    public static function text($name, $label, $value = null)
    {
        return view('form-fields.text', compact('name', 'label', 'value'))->render();
    }

    /**
     * @param $name
     * @param $label
     * @param null $value
     * @return string
     */
    public static function email($name, $label, $value = null)
    {
        return view('form-fields.email', compact('name', 'label', 'value'))->render();
    }

    /**
     * @param $name
     * @param $label
     * @param null $value
     * @return string
     */
    public static function password($name, $label, $value = null)
    {
        return view('form-fields.password', compact('name', 'label', 'value'))->render();
    }

    /**
     * @param $name
     * @param $label
     * @param null $value
     * @return string
     */
    public static function select($name, $label, $options, $selected = null, $plugin = 'select2', $placeholder = 'اختر قيمة')
    {
        $placeholder = __('اختر');
        return view('form-fields.select', compact('name', 'label', 'options', 'selected', 'plugin', 'placeholder'))->render();
    }

    /**
     * @param $name
     * @param $label
     * @param null $value
     * @return string
     */
    public static function multiSelect($name, $label, $options, $selected = null, $plugin = 'select2', $placeholder = 'اختر قيمة')
    {
        $placeholder = __('اختر');
        return view('form-fields.multi-select', compact('name', 'label', 'options', 'selected', 'plugin', 'placeholder'))->render();
    }

    /**
     * @param $name
     * @param $label
     * @param $options
     * @param string $plugin
     * @param string $placeholder
     * @param null $selected
     * @return string
     */
    public static function multiFileUpload($name, $label, $plugin = "file_upload_preview")
    {
        return view('form-fields.multi-file-upload', compact('name', 'label', 'plugin'))->render();
    }

    /**
     * @param $name
     * @param $label
     * @return string
     */
    public static function textarea($name, $label, $value = null)
    {
        return view('form-fields.textarea', compact('name', 'label', 'value'))->render();
    }

    /**
     * @param $name
     * @param $label
     * @param $options
     */
    public static function checkBox($name, $label, $options, $value = null)
    {
        return view('form-fields.check-box', compact('name', 'label', 'options'))->render();
    }
    
    /**
     * @param $name
     * @param $label
     * @param $check -> checked
     */
    public static function radio($name, $label, $options, $checked = null)
    {
        return view('form-fields.radio', compact('name', 'label', 'options', 'checked'))->render();
    }

    /**
     * @param $name
     * @param $label
     * @param null $value
     * @return string
     */
    public static function dateTime($name, $label, $value = null)
    {
        return view('form-fields.date-time', compact('name', 'label', 'value'))->render();
    }
}