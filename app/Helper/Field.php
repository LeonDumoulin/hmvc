<?php

namespace Helper;

class Field
{
    public static function text($name, $label, $value = null)
    {
        return view('admin.components.form.text', compact('name', 'label', 'value'));
    }
}