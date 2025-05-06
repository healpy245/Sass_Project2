<?php

namespace App\DTOs;

use App\Models\Lead;

class LeadDTO
{
    public $name;
    public $phone;
    public $email;
    public $address;
    public $ID_number;
    public $status;

    public function __construct($name, $phone, $email, $address, $ID_number, $status)
    {
        $this->name = $name;
        $this->phone = $phone;
        $this->email = $email;
        $this->address = $address;
        $this->ID_number = $ID_number;
        $this->status = $status;
    }

    public static function fromModel(Lead $lead): self
    {
        return new self(
            $lead->name,
            $lead->phone,
            $lead->email,
            $lead->address,
            $lead->ID_number,
            $lead->status
        );
    }

    public static function collection($leads)
    {
        return $leads->map(fn($lead) => self::fromModel($lead));
    }
}
