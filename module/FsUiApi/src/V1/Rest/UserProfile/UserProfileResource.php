<?php
namespace FsUiApi\V1\Rest\UserProfile;

use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Laminas\ApiTools\ApiProblem\ApiProblem;
use Laminas\ApiTools\Rest\AbstractResourceListener;
use User\Exceptions\AlreadyExistsException;
use User\Service\AuthManager;
use User\Service\UserService;

class UserProfileResource extends AbstractResourceListener
{
    /** @var AuthManager */
    private $authManager;

    /** @var UserService */
    private $userService;

    /**
     * @param AuthManager $authManager
     * @param UserService $userService
     */
    public function __construct(AuthManager $authManager, UserService $userService)
    {
        $this->authManager = $authManager;
        $this->userService = $userService;
    }

    /**
     * @param mixed $data
     * @return ApiProblem|mixed
     * @throws NonUniqueResultException
     */
    public function create($data)
    {
       $email = $data->email;
       $password = $data->password;

        try {
            $this->userService->createUser($email, $password);
        } catch (NonUniqueResultException $e) {
           return new ApiProblem(409, 'Email already used');
        } catch (OptimisticLockException $e) {
        } catch (ORMException $e) {
        } catch (AlreadyExistsException $e) {
           return new ApiProblem(409, 'Email already used');
        }

        return $this->authManager->login($email, $password);
    }

    /**
     * Delete a resource
     *
     * @param  mixed $id
     * @return ApiProblem|mixed
     */
    public function delete($id)
    {
        return new ApiProblem(405, 'The DELETE method has not been defined for individual resources');
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
        return new ApiProblem(405, 'The GET method has not been defined for individual resources');
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
