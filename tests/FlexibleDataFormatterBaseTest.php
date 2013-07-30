<?php

abstract class FlexibleDataFormatterBaseTest extends PHPUnit_Framework_TestCase
{
    /**
     * @param $methods
     * @param $record
     * @return mixed
     */
    protected function getDataObjectStub($methods, $record)
    {
        return $this->getMock('DummyDataObject', $methods, array($record));
    }
}