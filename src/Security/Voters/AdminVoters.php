<?php

namespace App\Security\Voters;

use App\Entity\Assoc;
use App\Entity\Gpx;
use App\Entity\Maraude;
use App\Entity\SignalementAssoc;
use App\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

class AdminVoters extends Voter
{
    protected function supports($attribute, $subject)
    {
        return true;
    }

    protected function voteOnAttribute($attribute, $subject, TokenInterface $token)
    {
        $user = $token->getUser();

        if (!$user instanceof User) {
            return false;
        }

        // Check if the user is a super admin
        if ($user->hasRole('ROLE_SUPER_ADMIN')) {
            return true;
        }

        if ($user->hasRole('ROLE_MAPPER_COUNTRY')) {
            if (!($subject instanceof Gpx || $subject instanceof Assoc || $subject instanceof Maraude || $subject instanceof SignalementAssoc)) {
                return false;
            }

            if ($subject instanceof Assoc || $subject instanceof SignalementAssoc) {
                foreach ($user->getAccessedCountries() as $country) {
                    foreach ($country->getStates() as $state) {
                        $hasCity = $state->getCities()->contains($subject->getVille());
                        if ($hasCity) {
                            return true;
                        }
                    }
                }

                return false;
            } elseif ($subject instanceof Maraude) {
                foreach ($user->getAccessedCountries() as $country) {
                    foreach ($country->getStates() as $state) {
                        $hasCity = $state->getCities()->contains($subject->getAssoc()->getVille());
                        if ($hasCity) {
                            return true;
                        }
                    }
                }

                return false;
            }

            return false;
        }

        if ($user->hasRole('ROLE_MAPPER_STATE')) {
            if (!($subject instanceof Gpx || $subject instanceof Assoc || $subject instanceof Maraude || $subject instanceof SignalementAssoc)) {
                return false;
            }

            if ($subject instanceof Assoc || $subject instanceof SignalementAssoc) {
                foreach ($user->getAccessedStates() as $state) {
                    $hasCity = $state->getCities()->contains($subject->getVille());
                    if ($hasCity) {
                        return true;
                    }
                }

                return false;
            } elseif ($subject instanceof Maraude) {
                foreach ($user->getAccessedStates() as $state) {
                    $hasCity = $state->getCities()->contains($subject->getAssoc()->getVille());
                    if ($hasCity) {
                        return true;
                    }
                }

                return false;
            }

            return false;
        }

        if ($user->hasRole('ROLE_MAPPER_CITY')) {
            if (!($subject instanceof Gpx || $subject instanceof Assoc || $subject instanceof Maraude || $subject instanceof SignalementAssoc)) {
                return false;
            }

            if ($subject instanceof Assoc || $subject instanceof SignalementAssoc) {
                return $user->getAccessedCities()->contains($subject->getVille());
            } elseif ($subject instanceof Maraude) {
                return $user->getAccessedCities()->contains($subject->getAssoc()->getVille());
            }

            return false;
        }

        if ($user->hasRole('ROLE_ASSOCIATION')) {
            if (!($subject instanceof Assoc || $subject instanceof SignalementAssoc)) {
                return false;
            }

            if ($subject instanceof Assoc) {
                return $user->getAssociationsAccessed()->contains($subject);
            } /*elseif ($subject instanceof SignalementAssoc) {
                return $user->getAssociationsAccessed()->contains($subject->getAssociationTarget());
            }*/
        }

        return false;
    }
}
