<?php
namespace User\V1\Rest\UserAuth;

class UserAuthEntity
{
    /** @var int */
    public $id;

    public static function fromEntity($id)
    {
        $self = new self();
        $self->id = $id;

        return $self;
    }
}
