<?php

namespace Xml\Validation;

use Xml\StringWriter;

interface ValidationResultsInterface
{
    public function hasErrors(): bool;

    public function getErrorCount(): int;

    public function getWarningCount(): int;

    public function getResults(): array;

    public function write(StringWriter $writer, ValidationResultFormatterInterface $printer): void;
}
