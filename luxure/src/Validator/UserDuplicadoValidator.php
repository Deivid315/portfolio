<?php
// src/Validator/TamanhoArquivoValidator.php
namespace App\Validator;

use App\Repository\UserAuthenticate\AuthenticateRepository;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;
use Symfony\Component\Validator\Exception\UnexpectedValueException;

class UserDuplicadoValidator extends ConstraintValidator
{
    public function __construct(
        private AuthenticateRepository $authenticateRepository
    ) {
    }

    public function validate($username, Constraint $constraint)
    {
        if (!$constraint instanceof UserDuplicado) {
            return;
        }

        if (null === $username && is_string($username)) {
            return;
        }

        if ($this->authenticateRepository->confirmUsername($username)) {
            $this->context->buildViolation($constraint->username_existe)
                ->setParameter('{{ name }}', $username)
                ->addViolation();
        }
    }
}
