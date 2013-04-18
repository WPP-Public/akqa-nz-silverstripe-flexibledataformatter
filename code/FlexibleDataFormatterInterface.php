<?php

/**
 * Class FlexibleDataFormatterInterface
 */
interface FlexibleDataFormatterInterface extends DataObjectInterface
{
    /**
     * @return mixed
     */
    public function getReadableFields();
    /**
     * @return mixed
     */
    public function getDynamicFields();
}
