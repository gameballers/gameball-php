<?php

namespace Gameball\Service;




/**
 * Service factory class for API resources.
 *
 */
class CoreServiceFactory extends \Gameball\Service\AbstractServiceFactory
{
    /**
     * @var array<string, class>
     */
    private static $classMap = [
        'player' => PlayerService::class,
        'referral' => ReferralService::class,
        'event' => EventService::class,
        'transaction' => TransactionService::class,
        'action' => ActionService::class,
        'order' => OrderService::class,
        'coupon' => CouponService::class,
        'leaderboard' => LeaderboardService::class,
        'notification' => NotificationService::class,
        'configurations' => ConfigService::class,
        'batch' => BatchService::class
    ];

    protected function getServiceClass($name)
    {
        return \array_key_exists($name, self::$classMap) ? self::$classMap[$name] : null;
    }
}
