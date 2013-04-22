<?php

/**
 * Class FlexibleDataFormatter
 */
abstract class FlexibleDataFormatter
{
    /**
     * @param FlexibleDataFormatterInterface $obj
     * @return array|bool
     */
    public function convertDataObjectToArray(
        FlexibleDataFormatterInterface $obj
    ) {
        $content = array();

        foreach ($obj->getAllowedFields() as $fieldName) {
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
                        $content[$fieldName] = (boolean)$fieldValue->getValue();
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

        foreach ($obj->getAllowedHasOneRelations() as $relName) {
            if ($obj->{$relName . 'ID'}) {
                $content[$relName] = $this->convertDataObjectToArray($obj->$relName());
            }
        }

        foreach ($obj->getAllowedHasManyRelations() as $relName) {
            $items = $obj->$relName();
            if ($items instanceof DataObjectSet && count($items) > 0) {
                $content[$relName] = array();
                foreach ($items as $item) {
                    $content[$relName][] = $this->convertDataObjectToArray($item);
                }
            }
        }

        foreach ($obj->getAllowedManyManyRelations() as $relName) {
            $items = $obj->$relName();
            if ($items instanceof DataObjectSet && count($items) > 0) {
                $content[$relName] = array();
                foreach ($items as $item) {
                    $content[$relName][] = $this->convertDataObjectToArray($item);
                }
            }
        }

        return $content;
    }
    /**
     * @param FlexibleDataFormatterInterface $obj
     * @return bool
     */
    public function convertDataObject(
        FlexibleDataFormatterInterface $obj
    ) {
        $content = $this->convertDataObjectToArray($obj);
        if (is_array($content)) {
            return $this->format($content);
        } else {
            return false;
        }
    }
    /**
     * @param DataObjectSet $set
     * @return mixed
     */
    public function convertDataObjectSet(
        DataObjectSet $set
    ) {
        $content = array();
        if (count($set) > 0) {
            foreach ($set as $obj) {
                $objContent = $this->convertDataObjectToArray($obj);
                if (is_array($objContent)) {
                    $content[] = $objContent;
                }
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
