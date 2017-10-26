<?php

namespace LaraSpells\Template\AdminLte\Generators;

use LaraSpells\Generator\Generators\ViewCreateGenerator;
use LaraSpells\Generator\Schema\Table;
use LaraSpells\Generator\Stub;

class FormModelViewCreateGenerator extends ViewCreateGenerator
{

    public function __construct(Table $table)
    {
        parent::__construct($table, '');
    }

    public function getContent()
    {
        $stub = new Stub(file_get_contents(__DIR__.'/../stubs/form-model/form-create.stub'));
        $data = json_decode(json_encode($this->getTableData()), true);
        return $stub->render($data);
    }

}
