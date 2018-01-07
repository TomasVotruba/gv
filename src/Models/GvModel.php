<?php
namespace Gvera\Models;

/**
 * Model Class Doc Comment
 *
 * @category Class
 * @package  src/models
 * @author    Guido Vera
 * @license  http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link     http://www.github.com/veraguido/gv
 *
 */
abstract class GvModel
{
    private $service;
    private $serviceName;
    const SERVICES_PREFIX = "Gvera\\Services\\";

    protected function getService()
    {
        if (!$this->service) {
            $this->serviceName = self::SERVICES_PREFIX . (new \ReflectionClass($this))->getShortName() . 'Service';
            if (!class_exists($this->serviceName)) {
                throw new \Exception("service {$this->serviceName} doesn't exist. Please verify the name.");
            }

            $this->service = new $this->serviceName();
        }
        return $this->service;
    }
}
