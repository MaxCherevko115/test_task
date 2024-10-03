<?php

namespace App\Security\Voter;

use App\Entity\User;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\User\UserInterface;

final class UserVoter extends Voter
{
    public const UPDATE = 'USER_UPDATE';
    public const SHOW = 'USER_SHOW';
    public const DELETE = 'USER_DELETE';

    public function __construct(
        private Security $security,
    ) {
    }

    protected function supports(string $attribute, mixed $subject): bool
    {
        return in_array($attribute, [self::UPDATE, self::SHOW, self::DELETE])
            && $subject instanceof User;
    }

    protected function voteOnAttribute(string $attribute, mixed $subject, TokenInterface $token): bool
    {
        $authUser = $token->getUser();

        if (!$authUser instanceof UserInterface) {
            return false;
        }

        /** @var User $user */
        $user = $subject;

        return match($attribute) {
            self::SHOW => $this->canShow($user, $authUser),
            self::UPDATE => $this->canUpdate($user, $authUser),
            self::DELETE => $this->canDelete($user, $authUser),
            default => throw new \LogicException('This code should not be reached!')
        };
    }

    private function canUpdate(User $user, User $authUser): bool
    {
        return $this->canShow($user, $authUser);
    }

    private function canShow(User $user, User $authUser): bool
    {
        if ($this->security->isGranted('ROLE_ADMIN')) {
            return true;
        }

        if ($user->getId() === $authUser->getId()) {
            return true;
        }

        return false;
    }

    private function canDelete(User $user, User $authUser): bool
    {
        if ($this->security->isGranted('ROLE_ADMIN') && $user->getId() !== $authUser->getId()) {
            return true;
        }

        return false;
    }
}
