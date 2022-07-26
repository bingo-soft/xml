<?php

namespace Xml\Validation;

use Xml\Instance\ModelElementInstanceInterface;

interface ValidationResultInterface
{
    public function getType(): string;

    public function getElement(): ModelElementInstanceInterface;

    public function getMessage(): string;

    public function getCode(): int;
}
