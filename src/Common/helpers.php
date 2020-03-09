<?php

if (!function_exists('array_get')) {
    /**
     * Get an item from an array using "dot" notation.
     *
     * @param array  $array
     * @param string $key
     * @param mixed  $default
     *
     * @return mixed
     */
    function array_get($array, $key, $default = null)
    {
        if (is_null($key)) {
            return $array;
        }

        if (isset($array[$key])) {
            return $array[$key];
        }

        foreach (explode('.', $key) as $segment) {
            if (!is_array($array) || !array_key_exists($segment, $array)) {
                return value($default);
            }

            $array = $array[$segment];
        }

        return $array;
    }
}

if (!function_exists('array_has')) {
    function array_has($array, $key)
    {
        if (empty($array) || is_null($key)) {
            return false;
        }

        if (array_key_exists($key, $array)) {
            return true;
        }

        foreach (explode('.', $key) as $segment) {
            if (!is_array($array) || !array_key_exists($segment, $array)) {
                return false;
            }

            $array = $array[$segment];
        }

        return true;
    }
}

if (!function_exists('value')) {
    /**
     * Return the default value of the given value.
     *
     * @param mixed $value
     *
     * @return mixed
     */
    function value($value)
    {
        return $value instanceof Closure ? $value() : $value;
    }
}

if (!function_exists('hex2dec')) {
    /**
     * @param string $hex
     *
     * @return string
     */
    function hex2dec($hex)
    {
        $dec = '0';

        $len = strlen($hex);

        for ($i = 1; $i <= $len; $i++) {
            $n = $hex[$i - 1];
            if (ctype_xdigit($n)) {
                $dec = bcadd($dec, bcmul((string)hexdec($n), bcpow('16', (string)($len - $i))));
            }
        }

        return $dec;
    }
}

if (!function_exists('getRootCertSN')) {
    /**
     * @param string $certPath
     *
     * @return string|null
     */
    function getRootCertSN($certPath)
    {
        $array = explode('-----END CERTIFICATE-----', file_get_contents($certPath));

        $rootSN = null;

        foreach ($array as $i) {
            $ssl = openssl_x509_parse($i . '-----END CERTIFICATE-----');

            if (in_array($ssl['signatureTypeLN'], ['sha1WithRSAEncryption', 'sha256WithRSAEncryption'])) {
                $sn = getCertSN($ssl, true);
                if (is_null($rootSN)) {
                    $rootSN = $sn;
                } else {
                    $rootSN .= "_{$sn}";
                }
            }
        }

        return $rootSN;
    }
}

if (!function_exists('getCertSN')) {
    /**
     * @param string $cert
     * @param bool   $parsed
     *
     * @return string|null
     */
    function getCertSN($cert, $parsed = false)
    {
        if ($parsed) {
            $ssl = $cert;
        } else {
            if (is_file($cert)) {
                $cert = file_get_contents($cert);
            }
            $ssl = openssl_x509_parse($cert);
        }

        if (strpos($ssl['serialNumber'], '0x') === 0) {
            $ssl['serialNumber'] = hex2dec($ssl['serialNumber']);
        }

        $array = array_reverse($ssl['issuer']);

        $names = [];
        foreach ($array as $key => $value) {
            $names[] = "{$key}={$value}";
        }

        return md5(implode(',', $names) . $ssl['serialNumber']);
    }
}

if (!function_exists('getPublicKey')) {
    /**
     * @param string $certPath
     *
     * @return string
     */
    function getPublicKey($certPath)
    {
        $pkey = openssl_pkey_get_public(file_get_contents($certPath));
        $keyData = openssl_pkey_get_details($pkey);
        $public_key = str_replace('-----BEGIN PUBLIC KEY-----', '', $keyData['key']);
        return trim(str_replace('-----END PUBLIC KEY-----', '', $public_key));
    }
}
