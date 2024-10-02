<?php

namespace App\DTO;

use Symfony\Component\Validator\Constraints as Assert;

class StoreUserDTO
{
    public function __construct(
        #[Assert\NotBlank]
        #[Assert\Type('string')]
        #[Assert\Length(max: 8)]
        public readonly string $login,
    
        #[Assert\NotBlank]
        #[Assert\Type('string')]
        #[Assert\Length(max: 8)]
        public readonly string $phone,
    
        #[Assert\NotBlank]
        #[Assert\Type('string')]
        #[Assert\Length(max: 8)]
        public readonly string $password,
    ) {

    }
}
