<?php

/**
 * Class FlexibleDataFormatterInterface
 */
interface FlexibleDataFormatterInterface extends DataObjectInterface
{
    /**
     * @param array $config
     * @return mixed
     */
    public function getAllowedFields(array $config);
    /**
     * @param array $config
     * @return mixed
     */
    public function getAllowedHasOneRelations(array $config);
    /**
     * @param array $config
     * @return mixed
     */
    public function getAllowedHasManyRelations(array $config);
    /**
     * @param array $config
     * @return mixed
     */
    public function getAllowedManyManyRelations(array $config);
}
