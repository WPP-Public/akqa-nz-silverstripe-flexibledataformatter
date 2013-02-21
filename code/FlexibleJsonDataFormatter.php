<?php

class FlexibleJsonDataFormatter extends FlexibleDataFormatter
{
    protected $jsonService = false;

    protected $outputContentType = 'application/json';

    public function supportedExtensions()
    {
        return array(
            'json'
        );
    }

    public function supportedMimeTypes()
    {
        return array(
            'application/json',
            'text/x-json'
        );
    }

    protected function format(array $arr)
    {
        if (function_exists('json_encode')) {
            return json_encode($arr);
        } else {
            return $this->getJsonService()->encode($arr);
        }
    }

    public function convertStringToArray($json)
    {
        if (function_exists('json_decode')) {
            return json_decode($json, true);
        } else {
            return $this->getJsonService()->decode($json);
        }
    }

    protected function getJsonService()
    {
        if (!$this->jsonService) {
            require_once SAPPHIRE_PATH . '/thirdparty/json/JSON.php';
            $this->jsonService = new Services_JSON();
        }

        return $this->jsonService;
    }
}
