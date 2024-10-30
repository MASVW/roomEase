<?php

namespace App\Service;


use chillerlan\QRCode\Common\EccLevel;
use chillerlan\QRCode\Data\QRMatrix;
use chillerlan\QRCode\QRCode;
use chillerlan\QRCode\QROptions;

class QRService
{
    public function generate(string $data): string
    {
        $options = new QROptions([
            'version'          => 7,
            'outputType'       => QRCode::OUTPUT_IMAGE_PNG,
            'eccLevel'         => EccLevel::M,
            'scale'            => 5,
            'imageBase64'      => false,
            'imageTransparent' => false,
            'imageWidth'       => 300,
            'imageHeight'      => 300
        ]);

        $qrCode = new QRCode($options);

        return $qrCode->render($data);
    }
}
