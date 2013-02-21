<?php

require_once __DIR__ . '/DummyDataObject.php';

class FlexibleJsonDataFormatterTest extends PHPUnit_Framework_TestCase
{
    public function testFormat()
    {
        $do = new DummyDataObject(
            array(
                'Title' => 'This is a test title',
                'Something' => 'Not allowed'
            )
        );
        $formatter = new FlexibleJsonDataFormatter;
        $this->assertEquals(
            json_encode(
                array(
                    'DynamicField' => 'Test',
                    'Title' => 'This is a test title'
                )
            ),
            $formatter->convertDataObject($do)
        );
    }
}
