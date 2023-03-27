<?php namespace App\Service;

use App\Entity\User;
use App\Repository\UserRepository;
use Google\Service\PeopleService\Nickname;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\String\UnicodeString;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class UserRegistrationService
{

    const CREATE_NICK_TRY_COUNT = 100;

    public function __construct(private UserRepository $userRepository, private ValidatorInterface $validator)
    {
    }

    public function registerUserByFacebook(array $userData, Request $request): ?User
    {

        $myUser = new User();

        // User Profile Data
        $myUser->setNickname($this->createNickByAccountName($userData["name"]));
        $myUser->setAccountname($userData["name"]);
        $myUser->setPassword(md5($userData["id"]));
        $myUser->setEmail($userData["email"]);

        // Prepare Default Locale
        $systemsDefaultLocale = $request->getLocale();

        // Fill Defaults
        $myUser = $this->fillUserDefaults($myUser, NULL);

        // Validate User
        $validationErrors = $this->validator->validate($myUser);

        if (count($validationErrors) > 0) {
            return NULL;
        }

        // Register User
        $this->userRepository->save($myUser, TRUE);

        // Return Registered User
        return $myUser;

    }

    public function registerUserByGoogle(array $userData, Request $request): ?User
    {

        $myUser = new User();

        // User Profile Data
        $myUser->setNickname($this->createNickByAccountName($userData["name"]));
        $myUser->setAccountname($userData["name"]);
        $myUser->setPassword(md5($userData["sub"]));
        $myUser->setEmail($userData["email"]);

        // Prepare Default Locale
        $systemsDefaultLocale = $request->getLocale();

        // Fill Defaults
        $myUser = $this->fillUserDefaults($myUser, NULL);

        // Validate User
        $validationErrors = $this->validator->validate($myUser);

        if (count($validationErrors) > 0) {
            return NULL;
        }

        // Register User
        $this->userRepository->save($myUser, TRUE);

        // Return Registered User
        return $myUser;

    }

    private function fillUserDefaults(User $myUser, $defaultLocale = NULL): User
    {
        $myUser->setHasbusiness(FALSE);
        $myUser->setRoles(["ROLE_USER"]);
        $myUser->setApprovalbadge(FALSE);
        $myUser->setDefaultlocale($defaultLocale);
        return $myUser;
    }


    private function createNickByAccountName(string $accountName): string
    {
        // Create Unicode string
        $accountName = new UnicodeString($accountName);

        // Convert to Lower
        $nickName = $accountName->lower();

        // Convert to Ascii
        $nickName = $nickName->ascii();

        // Convert to Snake Case
        $nickName = $nickName->snake();

        // Convert _ to .
        $nickName = str_replace('_', '.', $nickName);

        // Check nickname already exist.
        $ifExist = $this->userRepository->findOneBy(["nickname" => $nickName]);

        if ($ifExist instanceof User) {
            return $this->createNewByNickname($nickName);
        }

        return $nickName;

    }

    private function createNewByNickname(string $nickname): string
    {

        while ($this->userRepository->findOneBy(["nickname" => $nickname]) === NULL) {
            $nickname .= random_int(0, 9);
        }

        return $nickname;

    }

}