<?php
namespace FsUiApi\V1\Rest\Authentication;

use Doctrine\ORM\NonUniqueResultException;
use Laminas\ApiTools\ApiProblem\ApiProblem;
use Laminas\ApiTools\Rest\AbstractResourceListener;
use User\Exceptions\InvalidDataException;
use User\Exceptions\LoggedInException;
use User\Exceptions\NonExistException;
use User\Service\AuthManager;

class AuthenticationResource extends AbstractResourceListener
{
    /** @var AuthManager */
    private $authManager;

    public function __construct(AuthManager $authManager)
    {
        $this->authManager = $authManager;
    }

    /**
     * @param mixed $data
     * @return ApiProblem|mixed|null
     * @throws NonUniqueResultException
     */
    public function create($data)
    {
        $email = $data->email;
        $password = $data->password;

        try {
            $user = $this->authManager->login($email, $password);
        } catch (LoggedInException $e) {
            return new ApiProblem(422, 'Already logged in');
        } catch ( NonExistException $e) {
            return new ApiProblem(422, 'Invalid password or email');
        } catch ( InvalidDataException $e) {
            return new ApiProblem(422, 'Invalid password or email');
        }

        if (!$user) {
            return new ApiProblem(422, 'Invalid password or email');
        }

        return AuthenticationEntity::fromEntity($user['id']);
    }

    /**
     * Delete a resource
     *
     * @param  mixed $id
     * @return ApiProblem|mixed
     */
    public function delete($id)
    {
        $this->authManager->logout();

        return true;
    }

    public function fetchAll($params = [])
    {
       $user = $this->authManager->getIfLoggedIn();

       return AuthenticationEntity::fromEntity($user['id'] ?? 0);
    }
}
