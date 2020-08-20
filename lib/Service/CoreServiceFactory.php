<?php

namespace Gameball\Service;




/**
 * Service factory class for API resources.
 *
 */
class CoreServiceFactory extends \Gameball\Service\AbstractServiceFactory
{
    /**
     * @var array<string, string>
     */
    private static $classMap = [
        'player' => PlayerService::class,
        'referral' => ReferralService::class,
        'event' => EventService::class,
        'transaction' => TransactionService::class,
        'action' => ActionService::class,
        'coupon' => CouponService::class
                               ];

    protected function getServiceClass($name)
    {
        return \array_key_exists($name, self::$classMap) ? self::$classMap[$name] : null;
    }
}
