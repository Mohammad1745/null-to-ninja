<?php

namespace App\Http\Services;

class Service
{
    /**
     * @var bool
     */
    protected bool $success;
    /**
     * @var string
     */
    protected string $message;
    /**
     * @var array
     */
    protected array $data;

    /**
     * @param array $data
     * @param string $message
     * @return array
     */
    protected function responseSuccess(string $message="", array $data=[]): array
    {
        return [
            'success' => true,
            'data' => $data,
            'message' => $message
        ];
    }

    /**
     * @param array $data
     * @param string $message
     * @return array
     */
    protected function responseError(string $message="", array $data=[]): array
    {
        return [
            'success' => false,
            'data' => $data,
            'message' => $message
        ];
    }
}
