<?php

namespace KCS;

use KCS\Model\ToStringInterface;

class Render
{
    private string $responseType;
    public function render($data): string
    {
        if ($this->responseType === 'html') {
            return $this->renderHtml($data);
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

}