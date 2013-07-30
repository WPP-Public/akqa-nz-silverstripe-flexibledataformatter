<?php

require_once __DIR__ . '/DummyDataObject.php';

class FlexibleJsonDataFormatterTest extends FlexibleDataFormatterBaseTest
{
    /**
     * 
     */
    public function testFormat()
    {
        $do = $this->getDataObjectStub(
            array(
                'getAllowedFields',
                'DynamicField'
            ),
            array(
                'Title' => 'This is a test title',
                'Something' => 'Not allowed'
            )
        );

        $do->expects($this->any())
            ->method('getAllowedFields')
            ->will($this->returnValue(array('Title', 'DynamicField')));

        $do->expects($this->any())
            ->method('DynamicField')
            ->will($this->returnValue('Test'));
        
        $formatter = new FlexibleJsonDataFormatter;
        $this->assertEquals(
            json_encode(
                array(
                    'Title' => 'This is a test title',
                    'DynamicField' => 'Test'
                )
            ),
            $formatter->convertDataObject($do)
        );
    }
}
