<?php

interface FlexibleDataFormatterInterface extends DataObjectInterface
{
    public function getReadableFields();
    public function getDynamicFields();
}
