<?php

namespace LaraSpells\Template\AdminLte;

use LaraSpells\Generator\SchemaResolver as BaseSchemaResolver;

class SchemaResolver extends BaseSchemaResolver
{
    protected $availableInputTypes = [
        'text', 
        'password', 
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
        'date'
    ];

    /**
     * Fill route schema
     *
     * @param array &$schema
     */
    protected function fillRouteSchema(array &$schema)
    {
        parent::fillRouteSchema($schema);
        data_fill($schema, 'route.middleware', 'auth');
    }

    protected function resolveFieldInputCkeditor($colName, array $fieldSchema, $tableName, $tableSchema)
    {
        data_fill($fieldSchema, 'display', 'html');
        return $fieldSchema;
    }

    protected function resolveFieldInputSelect2($colName, array $fieldSchema, $tableName, $tableSchema)
    {
        return $this->resolveOptionableField($colName, $fieldSchema, $tableName, $tableSchema);
    }

    protected function resolveFieldInputIcheckRadios($colName, array $fieldSchema, $tableName, $tableSchema)
    {
        return $this->resolveOptionableField($colName, $fieldSchema, $tableName, $tableSchema);
    }

    protected function resolveFieldInputIcheckCheckbox($colName, array $fieldSchema, $tableName, $tableSchema)
    {
        return $this->resolveOptionableField($colName, $fieldSchema, $tableName, $tableSchema);
    }

}
