<?php

namespace App\Traits;

trait ApiResponses
{

    protected function success($message, $statusCode = 200, $args = [])
    {
        $response = array_merge([
            'success' => true,
            'message' => $message,
        ], $args);

        return response()->json($response, $statusCode);
    }

    protected function error($message, $statusCode = 400, $args = null)
    {
        return response()->json([
            'success' => false,
            'message' => $message,
            $args
        ], $statusCode);
    }
    protected function validationError()
    {
        return $this->error('Validation failed', 422, [
            'fails' => [
                "name" => [
                    "The name must be at least 2 characters."
                ],
                "email" => [
                    "The email must be a valid email address."
                ],
                "phone" => [
                    "The phone field is required."
                ],
                "position_id" => [
                    "The position id must be an integer."
                ],
                "photo" => [
                    "The photo may not be greater than 5 Mbytes."
                ]
            ]
        ]);
    }
}
