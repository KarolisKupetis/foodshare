<?php
namespace User\Service;

use Doctrine\ORM\EntityManager;
use Laminas\ApiTools\MvcAuth\Authentication\AdapterInterface;
use Laminas\Authentication\Result;
use Laminas\Crypt\Password\Bcrypt;
use Laminas\Http\Request;
use Laminas\Http\Response;
use User\Entity\User;

class AuthAdapter implements AdapterInterface
{
    /**
     * User email.
     * @var string
     */
    private $email;

    /**
     * Password
     * @var string
     */
    private $password;

    /**
     * Entity manager.
     * @var EntityManager
     */
    private $entityManager;

    /**
     * Constructor.
     */
    public function __construct($entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * Sets user email.
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * Sets password.
     */
    public function setPassword($password)
    {
        $this->password = (string)$password;
    }

    /**
     * Performs an authentication attempt.
     */
    public function authenticate()
    {
        // Check the database if there is a user with such email.
        /** @var User $user */
        $user = $this->entityManager->getRepository(User::class)->findById($this->email);

        if ($user === null) {
            return new Result(
                Result::FAILURE_IDENTITY_NOT_FOUND,
                null,
                ['Invalid credentials.']);
        }

        $bcrypt = new Bcrypt();
        $passwordHash = $user->getPassword();

        if ($bcrypt->verify($this->password, $passwordHash)) {
            return new Result(
                Result::SUCCESS,
                $this->email,
                ['Authenticated successfully.']);
        }

        return new Result(
            Result::FAILURE_CREDENTIAL_INVALID,
            null,
            ['Invalid credentials.']);
    }

    public function provides(): array
    {
        return [
            'session',
        ];
    }

    public function matches($type)
    {
        return $type === 'session';
    }

    public function getTypeFromRequest(Request $request)
    {
        return false;
    }

    /**
     * @inheritDoc
     */
    public function preAuth(Request $request, Response $response)
    {
    }
}
