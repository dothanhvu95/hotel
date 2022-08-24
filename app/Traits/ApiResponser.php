<?php

namespace App\Traits;

use App\Utils\Result;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

trait ApiResponser
{
    /**
     * @param array $data
     * @param integer $code
     * @param string $message
     *
     *
     * @return string
     */
    public function successResponse($data = [], $code = Result::OK, $message = null)
    {
        $response = [
            'success' => true,
            'result_code' => $code,
            'result' => $message ?: Result::$resultMessage[$code],
            'data' => $data,
        ];

        return response()->json($response);
    }

    /**
     * @param integer $code
     * @param string $message
     * @param array $errors
     *
     * * 
     *
     * @return string
     */
    public function errorResponse($code = Result::ERROR, $message = null, $errors = [])
    {
        if ($code == Response::HTTP_TOO_MANY_REQUESTS) {
            $errors = null;
            $message = __('messages.errors.error_to_many_request');
        }

        $response = [
            'success' => false,
            'result_code' => $code,
            'result' => $message ?: Result::$resultMessage[$code],
            // 'data' => $errors,
        ];

        return response()->json($response);
    }

    /**
     * The function response paging success
     *
     * @param null $current
     * @param null $total
     * @param array $data
     * @return JsonResponse
     */
    public function responsePagingSuccess($current = null, $total = null, $data = [])
    {
        $response = [
            'success' => true,
            'result_code' => Result::OK,
            'current' => $current,
            'total' => $total,
            'result' => 'Success',
            'data' => $data
        ];

        return response()->json($response);
    }

    /**
     * Pagination Cursors
     *
     * @param null|array $cursors
     * @param array $data
     *
     * @return JsonResponse
     */
    public function responsePagingCursorsSuccess($cursors = null, $data = [])
    {
        $response = [
            'success' => true,
            'result_code' => Result::OK,
            'cursors' => $cursors,
            'result' => 'Success',
            'data' => $data
        ];

        return response()->json($response);
    }
}
