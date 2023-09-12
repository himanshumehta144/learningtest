<?php
namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Data\DataCollection;

class UserResource extends JsonResource
{

    public static function collection($resource)
    {
        return tap(new DataCollection($resource, static::class), function ($collection) {
            if (property_exists(static::class, 'preserveKeys')) {
                $collection->preserveKeys = (new static([]))->preserveKeys === true;
            }
        });
    }

    /**
     * @var array
     */
    protected $withoutFields = [];


    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return $this->filterFields([
            'id' => $this->id,
            "name" => ($this->name ?? ""),
            "email" => ($this->email ?? ""),
            'email_verified_at' => ($this->email_verified_at ?? ""),
            'email_verified' => $this->hasVerifiedEmail(),
            'created_at' => $this->created_at,
        ]);
    }

    /**
     * Set the keys that are supposed to be filtered out.
     *
     * @param array $fields
     * @return $this
     */
    public function hide(array $fields)
    {
        $this->withoutFields = $fields;
        return $this;
    }
    /**
     * Remove the filtered keys.
     *
     * @param $array
     * @return array
     */
    protected function filterFields($array)
    {
        return collect($array)->forget($this->withoutFields)->toArray();
    }
}
