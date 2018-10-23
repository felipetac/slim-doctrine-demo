<?php
namespace App\Transformer;

use App\Entity\User as UserEntity;
use League\Fractal\TransformerAbstract;

class User extends TransformerAbstract
{
	public function transform(UserEntity $user)
	{
	    return [
            'id' => $user->getId(),
            'username' => $user->getUsername(),
            'registered_at' => $user->getRegisteredAt()
                                    ->format(\DateTime::ATOM),
            'links'   => [
                [
                    'rel' => 'self',
                    'uri' => '/user/'.$user->getId(),
                ]
            ],
        ];
	}
}