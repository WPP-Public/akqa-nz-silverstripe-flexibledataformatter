<?php

class DummyFormatter extends FlexibleDataFormatter
{
    protected function format(array $arr)
    {
        return $arr;
    }

    public function supportedExtensions()
    {
        return array(
            'dummy'
        );
    }

    public function supportedMimeTypes()
    {
        return array(
            'text/dummy'
        );
    }
}
