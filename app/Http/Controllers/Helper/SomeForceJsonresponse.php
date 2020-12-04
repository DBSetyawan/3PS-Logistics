<?php

namespace warehouse\Http\Controllers\Helper;

use Illuminate\Http\Request;
use warehouse\Http\Controllers\Controller;

class SomeForceJsonresponse extends Controller
{
    const STATUS_SUCCESS = true;
    const STATUS_ERROR = false;

    private $data = [];

    private $error = '';

    private $success = false;

   
    public function __construct($data = [], string $error = '')
    {
        if ($this->shouldBeJson($data)) {
            $this->data = $data;
        }

        $this->error = $error;
        $this->success = !empty($data);
    }

    public function success($data = [])
    {
        $this->success = true;
        $this->data = $data;
        $this->error = '';
    }

    public function fail($error = '')
    {
        $this->success = false;
        $this->error = $error;
        $this->data = [];
    }

  
    public function jsonSerialize()
    {
        return [
            'success' => $this->success,
            'data' => $this->data,
            'error' => $this->error,
        ];
    }

    private function shouldBeJson($content): bool
    {
        return $content instanceof Arrayable ||
            $content instanceof Jsonable ||
            $content instanceof \ArrayObject ||
            $content instanceof \JsonSerializable ||
            is_array($content);
    }
}
