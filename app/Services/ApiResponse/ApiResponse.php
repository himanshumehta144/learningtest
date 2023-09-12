<?php

namespace App\Services\ApiResponse;

trait ApiResponse
{
    /**
     * To send api response in jsone formate
     * @param $result
     * @param $statusCode
     * @param $message string
     */
    public function sendResponse($result, $message, $statusCode)
    {
        $response = [
            'status_code' => $statusCode,
            'message' => $message,
            'data' => $result,

        ];
        return response()->json($response, $statusCode);
    }

    public function sendArrayResponse($result, $message, $statusCode)
    {
        $response = [
            'status_code' => $statusCode,
            'data' => $result,
            'message' => $message,
        ];
        return $response;
    }

    /**
     *For api pagination
     */
    public function paginationFormate($resource)
    {

        if(!isset($resource->toArray()['total'])){
            return [];
        }

        return [
            'total' => $resource->total(),
            'count' => $resource->count(),
            'per_page' => $resource->perPage(),
            'current_page' => $resource->currentPage(),
            'total_pages' => $resource->lastPage()
        ];
    }
}
