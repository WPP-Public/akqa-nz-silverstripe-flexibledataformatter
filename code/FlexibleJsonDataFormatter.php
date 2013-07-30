<?php

/**
 * Class FlexibleJsonDataFormatter
 */
class FlexibleJsonDataFormatter extends FlexibleDataFormatter
{
    /**
     * @var bool
     */
    protected $jsonService = false;
    /**
     * @param array $arr
     * @return string
     */
    protected function format(array $arr)
    {
        if (function_exists('json_encode')) {
            return json_encode($arr);
        } else {
            return $this->getJsonService()->encode($arr);
        }
    }
    /**
     * @return Services_JSON
     */
    protected function getJsonService()
    {
        if (!$this->jsonService) {
            require_once FRAMEWORK_PATH . '/thirdparty/json/JSON.php';
            $this->jsonService = new Services_JSON();
        }

        return $this->jsonService;
    }
}
