<?php

require_once __DIR__ . '/DummyDataObject.php';

class FlexibleDataFormatterTest extends FlexibleDataFormatterBaseTest
{
    /**
     * @return FlexibleDataFormatter
     */
    protected function getFormatterStub()
    {
        $stub = $this->getMockForAbstractClass('FlexibleDataFormatter');
        $stub->expects($this->any())
            ->method('format')
            ->will($this->returnArgument(0));
        return $stub;
    }
    /**
     * 
     */
    public function testConvertDataObjectToArray()
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
        
        $formatter = $this->getFormatterStub();
        $this->assertEquals(
            array(
                'Title' => 'This is a test title',
                'DynamicField' => 'Test'
            ),
            $formatter->convertDataObjectToArray($do)
        );
        
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
            ->will($this->returnValue(array()));

        $do->expects($this->any())
            ->method('DynamicField')
            ->will($this->returnValue('Test'));
        
        $this->assertEquals(
            array(),
            $formatter->convertDataObjectToArray($do)
        );
    }

    public function testConvertDataObject()
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
        
        $formatter = $this->getFormatterStub();
        
        $this->assertEquals(
            array(
                'Title' => 'This is a test title',
                'DynamicField' => 'Test'
            ),
            $formatter->convertDataObject($do)
        );
        
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
            ->will($this->returnValue(array()));
        
        $this->assertEquals(
            array(),
            $formatter->convertDataObject($do)
        );
    }

    public function testConvertDataObjectSet()
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
        
        
        $formatter = $this->getFormatterStub();
        $dos = new ArrayList();
        $dos->push(
            clone $do
        );
        $dos->push(
            clone $do
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
