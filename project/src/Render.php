<?php

namespace KCS;

use KCS\Model\ToArrayInterface;
use KCS\Model\ToStringInterface;

class Render
{
    private string $responseType;
    public function render($data): string
    {
        switch ($this->responseType) {
            case "html":
                return $this->renderHtml($data);
            case "json":
                return $this->renderJson($data);
        }
        return 'Unknown response type';
    }

    public function responseType($type): void
    {
        $this->responseType = $type;
    }

    private function renderHtml($data): string
    {
        $str = '';

        if ($data instanceof ToStringInterface){
            return $data;
        }

        if (is_array($data)) {
            foreach ($data as $item) {
                if ($item instanceof ToStringInterface){
                    $str .= "<br>" . $item;
                } elseif(is_array($item)) {
                    $str .= "<br>" . implode(',', $item);
                } elseif(is_string($item)) {
                    return $item;
                } else {
                    return "Unknown data provided<br>";
                }
            }
            return $str ?: 'Missing data.';
        } else {
            return $data;
        }
    }

    private function renderJson($data): string
    {
        header("content-type:application/json"); //todo - figure out is this place is ok.
        $arr = $this->prepareArray($data);
        return json_encode($arr, JSON_PRETTY_PRINT);
    }

    private function prepareArray($data)
    {
        if (!is_array($data) && !$data instanceof ToArrayInterface) {
            return $data;
        } else {
            if (is_array($data)) {
                $arr = $data;
            } elseif ($data instanceof ToArrayInterface) {
                $arr = $data->toArray();
            }

            $arrReturn = [];
            foreach ($arr as $key => $item) {
                $arrReturn[$key] = $this->prepareArray($item);
            }
            return $arrReturn;
        }
    }

}