<?php
namespace FsUiApi\V1\Rest\Authentication;

class AuthenticationEntity
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
