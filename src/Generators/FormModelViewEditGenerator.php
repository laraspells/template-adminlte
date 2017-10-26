<?php

namespace LaraSpells\Template\AdminLte\Generators;

use LaraSpells\Generator\Generators\ViewEditGenerator;
use LaraSpells\Generator\Schema\Table;
use LaraSpells\Generator\Stub;

class FormModelViewEditGenerator extends ViewEditGenerator
{

    public function __construct(Table $table)
    {
        parent::__construct($table, '');
    }

    public function getContent()
    {
        $stub = new Stub(file_get_contents(__DIR__.'/../stubs/form-model/form-edit.stub'));
        $data = json_decode(json_encode($this->getTableData()), true);
        return $stub->render($data);
    }

}
