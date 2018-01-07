<?php
namespace Gvera\Cache;

/**
 * Cache Class Doc Comment
 *
 * @category Class
 * @package  src/cache
 * @author    Guido Vera
 * @license  http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link     http://www.github.com/veraguido/gv
 *
 */
class Cache
{
    private static $exception;

    /**
     * it will ping redis to check the availability of the service, if it's not present it will use files as default.
     * @return FilesCache|RedisCache
     */
    public static function getCache()
    {

        try {
            RedisCache::getInstance()->ping();
        } catch (\Exception $e) {
            self::$exception = $e;
        }

        if (isset(self::$exception)) {
            $cache = FilesCache::getInstance();
        } else {
            $cache = RedisCache::getInstance();
        }

        return $cache;
    }
}
