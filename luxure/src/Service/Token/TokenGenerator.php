<?php

declare(strict_types=1);

namespace App\Service\Token;

use Ramsey\Uuid\Uuid;

class TokenGenerator
{
    public function gereToken(string $dado1, ?string $dado2 = "nulo 1", ?string $dado3 = "nulo 2"): string
    {

        $currentTimestamp = time();

        $y = date('Y', $currentTimestamp);
        $m = date('m', $currentTimestamp);
        $d = date('d', $currentTimestamp);
        $h = date('H', $currentTimestamp);
        $i = date('i', $currentTimestamp);
        $s = date('s', $currentTimestamp);
        $aleatorio_hash1 = hash("sha256", $dado1);
        $aleatorio_hash2 =  hash("sha256", $dado2);
        $aleatorio_hash3 = hash("sha256", $dado3);
        $r = new \Random\Randomizer();
        $aleatorio_random = bin2hex($r->getBytes(50));
        $seguro = bin2hex(random_bytes(10));
        $msg = $h . $m . $aleatorio_hash1 . $y . $d . $aleatorio_hash2 . $aleatorio_random
            . $i . $seguro . $s . $aleatorio_hash3 . rand(111, 9999) . Uuid::uuid4()->toString();

        return $msg;
    }

    public function confirmToken(string $codigo): bool
    {
        $regex = '/^([01]\d|2[0-3])(0[1-9]|1[0-2])([0-9a-f]{64})/i';

        if (preg_match($regex, $codigo)) {
            $restante = substr($codigo, 68);
            if (preg_match('/^\d{4}/', $restante, $matches)) {
                $quatro_digitos = $matches[0];
                if (strlen($quatro_digitos) == 4) {
                    $regex2 = '/^(20[23][0-9])/';
                    if (preg_match($regex2, $restante)) {
                        $restante2 = substr($restante, 4);
                        $regex3 = '/^(0[1-9]|[12]\d|3[01])([0-9a-f]{64})([0-9a-fA-F]{100})([0-5]\d)([0-9a-fA-F]{20})([0-5]\d)([0-9a-f]{64})([0-9]{3,4})([0-9a-f]{8}-[0-9a-f]{4}-4[0-9a-f]{3}-[89ab][0-9a-f]{3}-[0-9a-f]{12})$/';;
                        if (preg_match($regex3, $restante2)) {
                            return true;
                        }
                    }
                }
            }
        }

        return false;
    }
}
