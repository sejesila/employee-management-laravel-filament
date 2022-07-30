<?php

namespace App\Http\Resources;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use JsonSerializable;

class EmployeeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array|Arrayable|JsonSerializable
     */
    public function toArray($request): array|JsonSerializable|Arrayable
    {
        return[
            'id' => $this->id,
            'firstName' => $this->first_name,
            'lastName' => $this->last_name,
            'address' => $this->address,
            'countryId' => $this->country_id,
            'stateId' => $this->state_id,
            'cityId' => $this->city_id,
            'departmentId' => $this->department_id,
            'birthDate' => $this->birth_date,
            'zip_code' => $this->zip_code,
            'dateHired' => $this->date_hired,
        ];
    }
}
