<?php

namespace User\Service;

use User\Repository\UserRepository;

class MoneyController
{
    /** @var UserRepository */
    private $userRepository;

    private $authManager;

    public function __construct(UserRepository $userRepository, AuthManager $manager)
    {
        $this->userRepository = $userRepository;
        $this->authManager = $manager;
    }

    public function getMoney()
    {
        $this->authManager->logout();
        $user = $this->authManager->login('snow@gmail.com', 'nope');

        return $user->getId();
    }
}