<?php
namespace Gvera\Commands;

use Gvera\Helpers\entities\EntityManager;
use Gvera\Models\UserRole;

/**
 * Command Class Doc Comment
 *
 * @category Class
 * @package  src/commands
 * @author    Guido Vera
 * @license  http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link     http://www.github.com/veraguido/gv
 *
 */
class CreateNewUserRoleCommand implements ICommand
{
    private $roleName;
    private $priority;
    private $entityManager;

    public function __construct($name, $priority)
    {
        $this->roleName = $name;
        $this->entityManager = EntityManager::getInstance();
        $this->priority = $priority;
    }

    /**
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function execute()
    {
        $userRole = new UserRole();
        $userRole->setName($this->roleName);
        $userRole->setRolePriority($this->priority);
        $this->entityManager->persist($userRole);
        $this->entityManager->flush();
    }
}
