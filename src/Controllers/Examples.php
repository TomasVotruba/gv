<?php

namespace Gvera\Controllers;


use Gvera\Cache\Cache;
use Gvera\Events\QWEEvent;
use Gvera\Helpers\commands\CreateNewUserCommand;
use Gvera\Helpers\commands\LoginCommand;
use Gvera\Helpers\config\Config;
use Gvera\Helpers\entities\EntityManager;
use Gvera\Helpers\events\EventDispatcher;
use Gvera\Helpers\locale\Locale;
use Gvera\Cache\RedisCache;
use Gvera\Helpers\session\Session;
use Gvera\Models\User;
use Gvera\Models\UserStatus;
use Gvera\Services\UserService;


class Examples extends GvController
{
    public function index()
    {
        //echo phpinfo();
        //$this->httpResponse->redirect("/Cars/tiju");
        //$this->httpResponse->notFound();
    }

    public function tiju()
    {
        //$this->viewParams = array('asd' => 'iiiiuuuuuuuuujjjuuu');

        if (!Cache::getCache()->exists('asd')) {
            Cache::getCache()->save('asd', 'test ameo 2');
        }

        echo Cache::getCache()->load('asd');
    }

    public function tan()
    {

        Session::set("asd", 1);
        Session::toString();
        $count = Session::get('count') ? Session::get('count') : 1;

        echo $count;

        Session::set('count', ++$count);
    }

    public function login()
    {
        $loginCommand = new LoginCommand(
            $this->httpRequest->getParameter('username'),
            $this->httpRequest->getParameter('password')
        );
        $loginCommand->execute();
    }

    public function logout()
    {
        $us = new UserService();
        $us->logout();
    }

    public function asd()
    {
        /*$user = $this->entityManager->find('Gvera\Models\UserModel', 1);
        echo '<pre>';
        var_dump($user);
        echo '</pre>';*/
        //echo print_r(Session::get('user'));

    }

    public function qwe()
    {
        /*echo "first call, something happening, call to be made <br/>";
        $event = new QWEEvent(QWEEvent::QWE_NAME, 234);

        EventDispatcher::dispatchEvent(QWEEvent::QWE_NAME, $event);
        echo "<br />";

        echo "event dispatched, all done :), removing event listener now <br/>";

        EventDispatcher::removeEventListeners(QWEEvent::QWE_NAME);

        echo '<br/> sending signal again';

        EventDispatcher::dispatchEvent(QWEEvent::QWE_NAME, $event);*/


        /*echo '<pre>';
        var_dump(EntityManager::getInstance()->getRepository(User::class)->find(1)->getPassword());
        echo '</pre>';*/

        if($this->httpRequest->isPost()) {
            $registerUserCommand = new CreateNewUserCommand(
                $this->httpRequest->getParameter('username'),
                $this->httpRequest->getParameter('password'),
                $this->httpRequest->getParameter('email')
            );

            $registerUserCommand->execute();
            echo 'worked!';
        }


    }

    public function lorep() {
        echo Locale::getLocale("Hello world");
    }

    public function ipsum() {
        throw new \Exception('Test Exception for default controller');
    }
}