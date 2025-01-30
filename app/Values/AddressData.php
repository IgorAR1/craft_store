<?php

namespace App\Values;

use Illuminate\Http\Request;

final class AddressData
{
    public string $country;
    public string $region;
    public string $city;
    public string $district;
    public string $street;
    public string $building;
    public ?string $floor = null;
    public ?string $apartment_number = null;

    public function __construct(string $country, string $region, string $city, string $district, string $street,string $building,string $floor = null,string $apartmentNumber = null)
    {
        $this->country = $country;
        $this->region = $region;
        $this->city = $city;
        $this->district = $district;
        $this->street = $street;
        $this->building = $building;
        $this->floor = $floor;
        $this->apartment_number = $apartmentNumber;
    }

    public static function fromArray(array $data): self
    {
        return new self(
            country: $data['country'],
            region: $data['region'],
            city: $data['city'],
            district: $data['district'],
            street: $data['street'],
            building: $data['building'],
            floor: $data['floor'] ?? null,
            apartmentNumber: $data['apartmentNumber'] ?? null,
        );
    }

    public static function fromRequest(Request $request): self
    {
        $data = $request->all();

        return new self(
            country: $data['country'],
            region: $data['region'],
            city: $data['city'],
            district: $data['district'],
            street: $data['street'],
            building: $data['building'],
            floor: $data['floor'] ?? null,
            apartmentNumber: $data['apartmentNumber'] ?? null,
        );
    }
}
