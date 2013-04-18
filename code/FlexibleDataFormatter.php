<?php

/**
 * Class FlexibleDataFormatter
 */
abstract class FlexibleDataFormatter
{
    /**
     * @param FlexibleDataFormatterInterface $obj
     * @param null                           $readableFields
     * @return array|bool
     */
    public function convertDataObjectToArray(
        FlexibleDataFormatterInterface $obj,
        $readableFields = null
    ) {
        if (is_array($readableFields)) {
            $readableFields = $readableFields;
        } elseif (is_string($readableFields) && $obj->hasMethod($readableFields)) {
            $readableFields = $obj->{$readableFields}();
        } else {
            $readableFields = $obj->getReadableFields();
        }

        if (is_array($readableFields)) {

            $content = array();

            $fields = array_merge(
                array(
                    'ID',
                    'Created'
                ),
                $obj->getDynamicFields(),
                array_flip($obj->inheritedDatabaseFields())
            );

            foreach ($fields as $fieldName) {
                if (array_search($fieldName, $readableFields) !== false) {
                    if ($obj->hasMethod($fieldName)) {
                        $fieldValue = $obj->$fieldName();
                    } else {
                        $fieldValue = $obj->dbObject($fieldName);
                        if (is_null($fieldValue)) {
                            $fieldValue = $obj->$fieldName;
                        }
                    }

                    if ($fieldValue instanceof Object) {
                        switch (get_class($fieldValue)) {
                            case 'Boolean':
                                $content[$fieldName] = (boolean) $fieldValue->getValue();
                                break;
                            case 'PrimaryKey':
                                $content[$fieldName] = $obj->$fieldName;
                                break;
                            default:
                                $content[$fieldName] = $fieldValue->getValue();
                                break;
                        }
                    } else {
                        $content[$fieldName] = $fieldValue;
                    }
                }
            }

            foreach ($obj->has_one() as $relName => $relClass) {
                if (array_search($relName, $readableFields) !== false) {
                    if ($obj->{$relName . 'ID'}) {
                        $content[$relName] = $this->convertDataObjectToArray($obj->$relName(), $readableFields);
                    }
                }
            }

            foreach ($obj->has_many() as $relName => $relClass) {
                // Field filtering
                if (array_search($relName, $readableFields) !== false) {
                    $items = $obj->$relName();
                    if ($items instanceof DataObjectSet && count($items) > 0) {
                        $content[$relName] = array();
                        foreach ($items as $item) {
                            $content[$relName][] = $this->convertDataObjectToArray($item, $readableFields);
                        }
                    }
                }
            }

            return $content;
        } else {
            return false;
        }
    }
    /**
     * @param FlexibleDataFormatterInterface $obj
     * @param null                           $readableFields
     * @return bool
     */
    public function convertDataObject(
        FlexibleDataFormatterInterface $obj,
        $readableFields = null
    ) {
        $content = $this->convertDataObjectToArray($obj, $readableFields);
        if (is_array($content)) {
            return $this->format($content);
        } else {
            return false;
        }
    }
    /**
     * @param IteratorAggregate $set
     * @param null          $readableFields
     * @return mixed
     */
    public function convertDataObjectSet(
        IteratorAggregate $set,
        $readableFields = null
    ) {
        $content = array();
        foreach ($set as $obj) {
            $objContent = $this->convertDataObjectToArray($obj, $readableFields);
            if (is_array($objContent)) {
                $content[] = $objContent;
            }
        }

        return $this->format($content);
    }
    /**
     * @param array $arr
     * @return mixed
     */
    abstract protected function format(array $arr);
}
