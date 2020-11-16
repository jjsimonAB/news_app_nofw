<?php

namespace Src\router;

class Response
{
    private $status = 200;

    public function status(int $code)
    {
        $this->status = $code;
        return $this;
    }

    public function toJson($data = [])
    {
        http_response_code($this->status);
        header('Content-Type: application/json');
        $response = array(
            'status' => ($status === 200) ? 'failed' : 'success',
            'data' => $data['data'],
        );

        die(json_encode($response));
    }
}
