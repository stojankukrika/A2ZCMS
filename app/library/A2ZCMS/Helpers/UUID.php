<?php

namespace A2ZCMS\Helpers;

class Uuid {

    /**
* Generate a UUID v4
*
* The UUID is 36 characters with dashes, 32 characters without.
*
* @return string E.g. 67f71e26-6d76-4d6b-9b6b-944c28e32c9d
*/
    public static function v4($dashes = true)
    {
        if ($dashes)
        {
            $format = '%s-%s-%04x-%04x-%s';
        }
        else
        {
            $format = '%s%s%04x%04x%s';
        }

        return sprintf($format,

            // 8 hex characters
            bin2hex(openssl_random_pseudo_bytes(4)),

            // 4 hex characters
            bin2hex(openssl_random_pseudo_bytes(2)),

            // "4" for the UUID version + 3 hex characters
            mt_rand(0, 0x0fff) | 0x4000,

            // (8, 9, a, or b) for the UUID variant + 3 hex characters
            mt_rand(0, 0x3fff) | 0x8000,

            // 12 hex characters
            bin2hex(openssl_random_pseudo_bytes(6))
        );
    }

}