<?php

namespace Xml\Validation;

use Xml\StringWriter;
use Xml\Instance\ModelElementInstanceInterface;

interface ValidationResultFormatterInterface
{
    public function formatElement(StringWriter $writer, ModelElementInstanceInterface $element): void;

    public function formatResult(StringWriter $writer, ValidationResultInterface $result): void;
}
