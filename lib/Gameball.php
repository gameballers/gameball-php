<?php

namespace Gameball;

// NOTE:  no use of this class until we remove the enforcing disable of ssl verification and uncomment the part of CA certificates

/**
 * Class Gamrball.
 */
class Gameball
{
    /** @var bool Defaults to true. */
    public static $verifySslCerts = true;

    /**
     * @return string
     */
    public static function getDefaultCABundlePath()
    {
        return \realpath(__DIR__ . '/../data/cacert.pem');
    }

    /**
     * @return bool
     */
    public static function getVerifySslCerts()
    {
        return self::$verifySslCerts;
    }

    /**
     * @param bool $verify
     */
    public static function setVerifySslCerts($verify)
    {
        self::$verifySslCerts = $verify;
    }
}
