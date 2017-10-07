<?php

namespace LaraSpells\Template\AdminLte\Generators;

use LaraSpells\Generator\Generators\ControllerGenerator;
use LaraSpells\Generator\Generators\MethodGenerator;
use LaraSpells\Generator\Schema\Field;
use LaraSpells\Generator\Schema\Table;
use LaraSpells\Generator\Stub;
use LaraSpells\Generator\Traits\Concerns\TableUtils;

class FormModelControllerGenerator extends ControllerGenerator
{
    const CLASS_REQUEST = 'Illuminate\Http\Request';
    const CLASS_RESPONSE = 'Illuminate\Http\Response';

    public function __construct(Table $tableSchema)
    {
        $this->setTableSchema($tableSchema);
        $this->initClass();
        // $this->addMethodsFromReflection();
        $method = $this->addMethod('__construct');
        $this->setMethodConstruct($method);
        $method = $this->addMethod('pageList');
        $this->setMethodPageList($method);
        $method = $this->addMethod('pageDetail');
        $this->setMethodPageDetail($method);
        $method = $this->addMethod('formCreate');
        $this->setMethodFormCreate($method);
        $method = $this->addMethod('postCreate');
        $this->setMethodPostCreate($method);
        $method = $this->addMethod('formEdit');
        $this->setMethodFormEdit($method);
        $method = $this->addMethod('postEdit');
        $this->setMethodPostEdit($method);
        $method = $this->addMethod('findOrFail');
        $this->setMethodFindOrFail($method);
        $method = $this->addMethod('form');
        $this->setMethodForm($method);
        $this->addMethodsFormOptions();
    }

    protected function initClass()
    {
        $this->setClassName($this->getTableSchema()->getControllerClass());
        $this->setParentClass('App\Http\Controllers\Controller');
        $this->useClass(static::CLASS_REQUEST);
        $this->useClass('LaraSpells\FormModel\FormModel');
        $models = $this->getRequiredModels();
        foreach($models as $varName => $model) {
            $label = ucfirst(snake_case($varName, ' '));
            $this->addProperty($varName, $model, 'protected', null, $label.' model');
        }
        $this->setDocblock(function($docblock) {
            $authorName = $this->getTableSchema()->getRootSchema()->getAuthorName();
            $authorEmail = $this->getTableSchema()->getRootSchema()->getAuthorEmail();
            $docblock->addText("Generated by LaraSpell");
            $docblock->addAnnotation("author", "{$authorName} <{$authorEmail}>");
            $docblock->addAnnotation("created", date('r'));
        });
    }

    protected function setMethodFormCreate(MethodGenerator $method)
    {
        $fieldsHasRelation = $this->getInputableFieldsHasRelation();
        $data = $this->getTableData();
        $method->addArgument('request', static::CLASS_REQUEST);
        $method->setDocblock(function($docblock) use ($data) {
            $docblock->addText("Display form create {$data->model_varname}");
            $docblock->addParam('request', static::CLASS_REQUEST);
            $docblock->setReturn(static::CLASS_RESPONSE);
        });

        $method->appendCode("\$data['title'] = 'Form Create {$data->label}';");
        $method->appendCode("\$data['form'] = \$this->form(new {$data->model->class})->withAction(route('{$data->route->post_create}'));");
        
        $method->nl();
        $method->appendCode("return view('{$data->view->form_create}', \$data);");
    }

    protected function setMethodPostCreate(MethodGenerator $method)
    {
        $data = $this->getTableData();
        $method->addArgument('request', static::CLASS_REQUEST);
        $method->setDocblock(function($docblock) use ($data) {
            $docblock->addText("Insert new {$data->model_varname}");
            $docblock->addParam('request', static::CLASS_REQUEST);
            $docblock->setReturn(static::CLASS_RESPONSE);
        });

        $method->appendCode("\$this->form(new Product)->submit(\$request);");
        $method->nl();

        $method->appendCode("
            \$message = '{$data->label} has been created!';
            return redirect()->route('{$data->route->page_list}')->with('info', \$message);
        ");
    }

    protected function setMethodFormEdit(MethodGenerator $method)
    {
        $fieldsHasRelation = $this->getInputableFieldsHasRelation();
        $data = $this->getTableData();
        $method->addArgument('request', static::CLASS_REQUEST);
        $method->addArgument($data->primary_varname);
        $method->setDocblock(function($docblock) use ($data) {
            $docblock->addText("Display form edit {$data->model_varname}");
            $docblock->addParam('request', static::CLASS_REQUEST);
            $docblock->addParam($data->primary_varname, 'string');
            $docblock->setReturn(static::CLASS_RESPONSE);
        });

        $initModelCode = $this->getInitModelCode();
        $method->appendCode($initModelCode);
        $method->nl();
        $view = $data->view->form_edit;
        $method->appendCode("\$data['title'] = 'Form Edit {$data->label}';");
        $method->appendCode("\$data['form'] = \$this->form(\${$data->model_varname})->withAction(route('{$data->route->post_edit}', [\${$data->primary_varname}]));");
        $method->nl();
        $method->appendCode("return view('{$view}', \$data);");
    }

    protected function setMethodPostEdit(MethodGenerator $method)
    {
        $data = $this->getTableData();
        $method->addArgument('request', static::CLASS_REQUEST);
        $method->addArgument($data->primary_varname);
        $method->setDocblock(function($docblock) use ($data) {
            $docblock->addText("Update specified {$data->model_varname}");
            $docblock->addParam('request', static::CLASS_REQUEST);
            $docblock->addParam($data->primary_varname, 'string');
            $docblock->setReturn(static::CLASS_RESPONSE);
        });

        $initModelCode = $this->getInitModelCode();

        $method->appendCode($initModelCode);
        $method->nl();
        $method->appendCode("\$this->form(\${$data->model_varname})->submit(\$request);");
        $method->nl();
        $method->appendCode("
            \$message = '{$data->label} has been updated!';
            return redirect()->route('{$data->route->page_list}')->with('info', \$message);
        ");
    }

    protected function setMethodForm(MethodGenerator $method)
    {
        $data = $this->getTableData();
        $method->setVisibility('protected');
        $method->addArgument($data->model_varname, $data->model->class);
        $method->setDocblock(function($docblock) use ($data) {
            $docblock->addText("Setup FormModel");
            $docblock->addParam($data->model_varname, $data->model->class_with_namespace);
            $docblock->setReturn('LaraSpells\FormModel\FormModel');
        });

        $fields = $this->phpify($this->getFormFields(), true);

        $method->appendCode("return FormModel::make(\${$data->model_varname}, {$fields});");
    }

    protected function getFormFields()
    {
        $schema = $this->tableSchema;
        $data = $this->getTableData();
        $rootSchema = $schema->getRootSchema();
        $inputableFields = $schema->getInputableFields();
        $fields = [];
        
        foreach($inputableFields as $field) {
            $params = $field->getInputParams();
            $key = $field->getColumnName();
            $rules = $field->getRules();
            
            if (isset($params['required'])) {
                unset($params['required']);
            }

            if (isset($params['name'])) {
                unset($params['name']);
            }

            if ($relation = $field->getRelation() AND isset($params['options'])) {
                $varName = $relation['var_name'];
                $methodName = 'get'.ucfirst(camel_case($varName));
                $params['options'] = "eval(\"\$this->{$methodName}()\")";
            }

            if ($field->isInputFile()) {
                $params['upload_disk'] = $field->getUploadDisk();
                $params['upload_path'] = $field->getUploadPath();
                foreach ($rules as $i => $rule) {
                    if (starts_with($rule, 'max:')) {
                        $rules[$i] = 'max:'.(2 * 1024);
                    }
                }
            }

            $ruleUnique = array_filter($rules, function($rule) {
                return starts_with($rule, 'unique:');
            });

            $others = [];
            if ($ruleUnique) {
                $rulesUpdate = $rules;
                $i = array_keys($ruleUnique)[0];
                $rulesUpdate[$i] = 'eval(""'.$rules[$i].',".$'.$data->model_varname.'->getKey()")';
                $others['if_update'] = [
                    'rules' => $rulesUpdate
                ];
            }

            $fields[$key] = array_merge([
                'input' => $field->get('input.type'),
            ], $params, [
                'rules' => $rules
            ], $others);
        }

        return $fields;
    }

}
