<?php

namespace App\DTO;

use Symfony\Component\Validator\Constraints as Assert;

class UpdateUserDTO
{
    public function __construct(
        #[Assert\Type('string')]
        #[Assert\Length(max: 8)]
        public readonly string|null $login,
    
        #[Assert\Type('string')]
        #[Assert\Length(max: 8)]
        public readonly string|null $phone,
    
        #[Assert\Type('string')]
        #[Assert\Length(max: 8)]
        public readonly string|null $password,
    ) {

    }
}
