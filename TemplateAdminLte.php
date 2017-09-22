<?php

namespace LaraSpells\Templates\AdminLte;

use LaraSpells\Generator\Commands\SchemaBasedCommand;
use LaraSpells\Generator\Template;

class AdminLteTemplate extends Template
{

    public function __construct(SchemaBasedCommand $command)
    {
        parent::__construct($command);
        $this->directory = realpath(__DIR__);
    }

    public function getSchemaResolver()
    {
        return new SchemaResolver;
    }

}
