<?php

final class RecurlyErrorTest extends RecurlyTestCase
{
    public function testFromJsonUnknownErrorResponse(): void
    {
        $data = (object)array(
            "error" => (object)array(
                "object" => "error",
                "type" => "unknown_type",
                "message" => "The error message"
            )
        );

        $response = new \Recurly\Response('');
        $response->setHeaders(array(
            'HTTP/1.1 500 Internal Server Error',
        ));
        $result = \Recurly\RecurlyError::fromJson($data, $response);
        $this->assertInstanceOf(
            \Recurly\RecurlyError::class,
            $result
        );
    }

    public function testApiErrorClass(): void
    {
        $data = (object)array(
            "error" => (object)array(
                "object" => "error",
                "type" => "test_error",
                "message" => "The error message"
            )
        );

        $response = new \Recurly\Response('');
        $response->setHeaders(array(
            'HTTP/1.1 500 Internal Server Error',
        ));
        $result = \Recurly\RecurlyError::fromJson($data, $response);
        $this->assertInstanceOf(
            \Recurly\Resources\ErrorMayHaveTransaction::class,
            $result->getApiError()
        );
    }
}