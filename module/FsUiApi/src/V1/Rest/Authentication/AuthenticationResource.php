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

    /**
     * Delete a collection, or members of a collection
     *
     * @param  mixed $data
     * @return ApiProblem|mixed
     */
    public function deleteList($data)
    {
        return new ApiProblem(405, 'The DELETE method has not been defined for collections');
    }

    /**
     * Fetch a resource
     *
     * @param  mixed $id
     * @return ApiProblem|mixed
     */
    public function fetch($id)
    {
       return 1;
    }

    /**
     * Fetch all or a subset of resources
     *
     * @param  array $params
     * @return ApiProblem|mixed
     */
    public function fetchAll($params = [])
    {
        return new ApiProblem(405, 'The GET method has not been defined for collections');
    }

    /**
     * Patch (partial in-place update) a resource
     *
     * @param  mixed $id
     * @param  mixed $data
     * @return ApiProblem|mixed
     */
    public function patch($id, $data)
    {
        return new ApiProblem(405, 'The PATCH method has not been defined for individual resources');
    }

    /**
     * Patch (partial in-place update) a collection or members of a collection
     *
     * @param  mixed $data
     * @return ApiProblem|mixed
     */
    public function patchList($data)
    {
        return new ApiProblem(405, 'The PATCH method has not been defined for collections');
    }

    /**
     * Replace a collection or members of a collection
     *
     * @param  mixed $data
     * @return ApiProblem|mixed
     */
    public function replaceList($data)
    {
        return new ApiProblem(405, 'The PUT method has not been defined for collections');
    }

    /**
     * Update a resource
     *
     * @param  mixed $id
     * @param  mixed $data
     * @return ApiProblem|mixed
     */
    public function update($id, $data)
    {
        return new ApiProblem(405, 'The PUT method has not been defined for individual resources');
    }
}
