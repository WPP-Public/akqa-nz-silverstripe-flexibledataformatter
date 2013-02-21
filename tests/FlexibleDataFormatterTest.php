<?php

require_once __DIR__ . '/DummyDataObject.php';
require_once __DIR__ . '/DummyFormatter.php';

class FlexibleDataFormatterTest extends PHPUnit_Framework_TestCase
{
    public function testConvertDataObjectToArray()
    {
        $do = new DummyDataObject(
            array(
                'Title' => 'This is a test title',
                'Something' => 'Not allowed'
            )
        );
        $formatter = new DummyFormatter;
        $this->assertEquals(
            array(
                'Title' => 'This is a test title',
                'DynamicField' => 'Test'
            ),
            $formatter->convertDataObjectToArray($do)
        );
        $this->assertEquals(
            array(),
            $formatter->convertDataObjectToArray($do, array())
        );
    }

    public function testConvertDataObject()
    {
        $do = new DummyDataObject(
            array(
                'Title' => 'This is a test title',
                'DynamicField' => 'Test'
            )
        );
        $formatter = new DummyFormatter;
        $this->assertEquals(
            array(
                'Title' => 'This is a test title',
                'DynamicField' => 'Test'
            ),
            $formatter->convertDataObject($do)
        );
        $this->assertEquals(
            array(),
            $formatter->convertDataObject($do, array())
        );
    }

    public function testConvertDataObjectSet()
    {
        $formatter = new DummyFormatter;
        $dos = new DataObjectSet();
        $dos->push(
            new DummyDataObject(
                array(
                    'Title' => 'This is a test title',
                    'DynamicField' => 'Test'
                )
            )
        );
        $dos->push(
            new DummyDataObject(
                array(
                    'Title' => 'This is a test title',
                    'DynamicField' => 'Test'
                )
            )
        );
        $this->assertEquals(
            array(
                array(
                    'Title' => 'This is a test title',
                    'DynamicField' => 'Test'
                ),
                array(
                    'Title' => 'This is a test title',
                    'DynamicField' => 'Test'
                )
            ),
            $formatter->convertDataObjectSet($dos)
        );
    }
}
