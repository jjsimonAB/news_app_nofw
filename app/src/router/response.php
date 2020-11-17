<?php

namespace Src\router;

class Response
{
    private int $status = 200;

    /**
     * Set the response status
     *
     * @return Response
     */
    public function status(int $code): Response
    {
        $this->status = $code;
        return $this;
    }

    /**
     * Send a response to the client
     *
     * @return void
     */
    public function toJson($data = []): void
    {
        http_response_code($this->status);
        header('Content-Type: application/json');
        $response = array(
            'status' => ($this->status === 200) ? 'success' : 'failed',
            'data' => $data['data'],
        );

        die(json_encode($response));
    }
}
