<?php
namespace FsUiApi\V1\Rest\UserProfile;

class UserProfileEntity
{
    public $id;

    public static function fromLogin(array $data)
    {
        $me = new self();
        $me->id = $data['id'];

        return $me;
    }
}
