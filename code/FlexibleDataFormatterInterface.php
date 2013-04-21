<?php

/**
 * Class FlexibleDataFormatterInterface
 */
interface FlexibleDataFormatterInterface extends DataObjectInterface
{
    /**
     * @return array
     */
    public function getAllowedFields();
    /**
     * @return array
     */
    public function getAllowedHasOneRelations();
    /**
     * @return array
     */
    public function getAllowedHasManyRelations();
    /**
     * @return array
     */
    public function getAllowedManyManyRelations();
}
