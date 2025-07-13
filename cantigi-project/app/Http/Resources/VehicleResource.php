<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class VehicleResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'car_type' => $this->car_type,
            'brand' => $this->brand,
            'model' => $this->model,
            'vehicle_image' => $this->vehicle_image,
            'license_plate' => $this->license_plate,
            'price_per_day' => $this->price_per_day,
            'purchase_date' => $this->purchase_Date,
            'last_maintenance_date' => $this->last_maintenance_date,
            'status' => $this->status
        ];
    }
}
