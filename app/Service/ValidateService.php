<?php

namespace App\Service;

use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class ValidateService
{
    public function validate(array $data)
    {
        $rules = [
            'eventName' => 'required|string|max:255',
            'eventDescription' => 'required|string|max:1000',
            'eventStart' => 'required|date_format:Y-m-d\TH:i|before:eventEnd',
            'eventEnd' => 'required|date_format:Y-m-d\TH:i|after:eventStart',
            'agreement' => 'required|boolean',
            'roomId' => 'required|integer|exists:rooms,id',
        ];

        $validator = Validator::make($data, $rules);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }

        return $validator->validated();
    }
}
