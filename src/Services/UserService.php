<?php namespace Gvera\Services;

use Gvera\Helpers\entities\EntityManager;
use Gvera\Helpers\locale\Locale;
use Gvera\Helpers\session\Session;
use Gvera\Helpers\validation\EmailValidationStrategy;
use Gvera\Helpers\validation\ValidationService;
use Gvera\Models\User;

/**
 * Service Class Doc Comment
 *
 * @category Class
 * @package  src/services
 * @author    Guido Vera
 * @license  http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link     http://www.github.com/veraguido/gv
 *
 */
class UserService
{
    const MODERATOR_ROLE_PRIORITY = 5;

    public function validateEmail($email)
    {
        return ValidationService::validate($email, [new EmailValidationStrategy()]);
    }

    public function generatePassword($plainPassword)
    {
        return password_hash($plainPassword, PASSWORD_BCRYPT);
    }

    public function validatePassword($plainPassword, $hash)
    {
        return password_verify($plainPassword, $hash);
    }

    /**
     * @param $username
     * @param $password
     * @throws \Exception
     */
    public function login($username, $password)
    {
        $em = EntityManager::getInstance()->getRepository(User::class);
        $user = $em->findOneBy(['username' => $username]);

        if ($user && $user->getUsername() == $username && $this->validatePassword($password, $user->getPassword())) {
            Session::set(
                'user',
                [
                    'username' => $username,
                    'userEmail' => $user->getEmail(),
                    'role' => $user->getRole()->getRolePriority()
                ]
            );
        } else {
            throw new \Exception(Locale::getLocale('user or password are incorrect'));
        }
    }

    public function logout()
    {
        Session::unset('user');
    }

    public static function isUserLoggedIn()
    {
        return Session::get('user') != null;
    }

    public static function getUserRole()
    {
        return Session::get('user') != null ? Session::get('user')['role'] : false;
    }
}
