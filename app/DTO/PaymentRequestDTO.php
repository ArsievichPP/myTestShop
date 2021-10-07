<?php

namespace App\DTO;

use Spatie\DataTransferObject\DataTransferObject;

class PaymentRequestDTO extends DataTransferObject
{
    public $name;

    public $stripeToken;

    public $phone;

    public $address;

    public $email;
}
