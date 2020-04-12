<?php
namespace User\Service;

use Doctrine\ORM\NonUniqueResultException;
use Laminas\Crypt\Password\Bcrypt;
use Laminas\Session\Container;
use Exception;
use User\Entity\User;
use User\Exceptions\AlreadyExistsException;
use User\Exceptions\InvalidDataException;
use User\Exceptions\LoggedInException;
use User\Exceptions\NonExistException;

class AuthManager
{
    /** @var Container  */
    private $session;

    /** @var UserService */
    private $userService;

    /**
     * Constructs the service.
     */
    public function __construct(UserService $userService)
    {
        $this->session = new Container('authorization');
        $this->userService = $userService;
    }

    /**
     * @param string $email
     * @param string $password
     * @return array[]
     * @throws NonUniqueResultException
     * @throws Exception
     */
    public function login(string $email, string $password): ?array
    {
        if ($this->session->user) {
            throw new LoggedInException('Already logged in');
        }

        $user = $this->userService->findByEmailAsArray($email);

        if (!$user) {
            throw new NonExistException('User does not exist');
        }

        $passwordHash = $user['password'];

        $crypt = new Bcrypt();

        if ($crypt->verify($password, $passwordHash)) {
            $this->session->user = $user;

            return $user;
        }

        throw new InvalidDataException('Invalid password or email');
    }

    /**
     * Performs user logout.
     */
    public function logout(): void
    {
        unset($this->session->user);
    }
}