<?php

class DummyDataObject extends DataObject implements FlexibleDataFormatterInterface
{
    public static $db = array(
        'Title' => 'Varchar(255)'
    );

    public function getReadableFields()
    {
        return array(
            'Title',
            'DynamicField'
        );
    }

    public function getDynamicFields()
    {
        return array(
            'DynamicField'
        );
    }

    public function DynamicField()
    {
        return 'Test';
    }
}
