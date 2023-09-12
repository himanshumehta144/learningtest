<?php

namespace App\Http\Resources\Data;

use App\Services\ApiResponse\ApiResponse;
use Illuminate\Http\Resources\Json\ResourceCollection;

class DataCollection extends ResourceCollection
{
    use ApiResponse;

    protected $withoutFields = [];
    public $collects;
    private $pagination;

    public function __construct($resource, $collects)
    {
        $this->pagination = $this->paginationFormate($resource);
        $this->collects = $collects;
        parent::__construct($resource);
    }

    // Transform the resource collection into an array.
    public function toArray($request)
    {
        return [
            'results' => $this->processCollection($request),
            $this->mergeWhen($this->pagination, [
                'pagination' => $this->pagination
            ]),
        ];
    }

    public function hide(array $fields)
    {
        $this->withoutFields = $fields;
        return $this;
    }
    // Send fields to hide to UsersResource while processing the collection.
    protected function processCollection($request)
    {
        return $this->collection->map(function ($resource) use ($request) {
            return $resource->hide($this->withoutFields)->toArray($request);
        })->all();
    }
}
