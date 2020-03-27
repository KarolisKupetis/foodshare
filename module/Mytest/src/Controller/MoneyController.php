<?php

namespace Mytest\Controller;

use Mytest\Repository\UserRepository;

class MoneyController
{
    /** @var UserRepository */
    private $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function getMoney()
    {
        var_dump($this->userRepository->getById(1));

        return 15;
    }
}