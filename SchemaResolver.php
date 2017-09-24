<?php

namespace LaraSpells\Template\AdminLte;

use LaraSpells\Generator\SchemaResolver as BaseSchemaResolver;

class SchemaResolver extends BaseSchemaResolver
{
    protected $availableInputTypes = [
        'text', 
        'textarea',
        'file',
        'image',
        'number',
        'email',
        'select',
        'select-multiple',
        'checkbox',
        'radio',
        'ckeditor',
        'tinymce',
        'select2',
        'select2-multiple',
        'icheck-radio',
        'icheck-checkbox',
    ];

    protected function resolveFieldInputCkeditor($colName, array $fieldSchema, $tableName)
    {
        data_fill($fieldSchema, 'display', 'html');
        return $fieldSchema;
    }

    protected function resolveFieldInputSelect2($colName, array $fieldSchema, $tableName)
    {
        return $this->resolveOptionableField($colName, $fieldSchema, $tableName);
    }

    protected function resolveFieldInputIcheckRadios($colName, array $fieldSchema, $tableName)
    {
        return $this->resolveOptionableField($colName, $fieldSchema, $tableName);
    }

    protected function resolveFieldInputIcheckCheckbox($colName, array $fieldSchema, $tableName)
    {
        return $this->resolveOptionableField($colName, $fieldSchema, $tableName);
    }

}
