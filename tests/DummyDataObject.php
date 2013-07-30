<?php

class DummyDataObject extends DataObject implements FlexibleDataFormatterInterface, TestOnly
{
    public static $db = array(
        'Title' => 'Varchar(255)'
    );
    
    /**
     * @param array $config
     * @return mixed
     */
    public function getAllowedFields(array $config)
    {
    }
    /**
     * @param array $config
     * @return mixed
     */
    public function getAllowedHasOneRelations(array $config)
    {
    }
    /**
     * @param array $config
     * @return mixed
     */
    public function getAllowedHasManyRelations(array $config)
    {
    }
    /**
     * @param array $config
     * @return mixed
     */
    public function getAllowedManyManyRelations(array $config)
    {
    }
}
