<?php

declare(strict_types=1);

namespace App\Document\Usuario;

use App\Document\Usuario\Embeded\AlterarSenha\TrocarSenha;
use App\Document\Usuario\Embeded\ConteudosUser\Conteudos;
use App\Document\Usuario\Embeded\InfoAdicionais\Informacoes;
use App\Document\Usuario\Embeded\ValidacaoConta\ValidacaoDaConta;
use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;
use Doctrine\ODM\MongoDB\Mapping\Annotations\EmbedOne;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

#[MongoDB\Document(collection: 'users')]
#[MongoDB\Index(keys: ['validacao_da_conta.expiracao' => 'asc'], expireAfterSeconds: 604800, sparse: true)]
#[MongoDB\Index(keys: ['trocar_senha.codigo' => 'asc'], sparse: true, unique: true)]
#[MongoDB\Index(keys: ['username' => 'text', 'alcunha' => 'text'], sparse: true)]
#[MongoDB\Index(keys: ['username' => 'asc'], sparse: true, unique: true)]
#[MongoDB\Index(keys: ['email' => 'asc'], unique: true)]
#[MongoDB\Index(keys: ['nascimento' => 1])]
#[MongoDB\Index(keys: ['conteudos.arquivos_publicos.detalhes.valor' => 1], sparse: true)]
#[MongoDB\Index(keys: ['conteudos.arquivos_publicos.detalhes.etnia' => 1], sparse: true)]
#[MongoDB\Index(keys: ['conteudos.arquivos_publicos.detalhes.cabelo' => 1], sparse: true)]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[MongoDB\Id]
    private $id;

    #[MongoDB\Field(type: 'string')]
    private string $username;

    #[MongoDB\Field(type: 'string')]
    private string $email;

    #[MongoDB\Field(type: 'string')]
    private string $password;

    #[MongoDB\Field(type: 'string')]
    private string $nome_completo;

    #[MongoDB\Field(type: 'string')]
    private string $alcunha;

    #[MongoDB\Field(type: 'int')]
    private int $celular;

    #[MongoDB\Field(type: 'string')]
    private string $status;

    #[MongoDB\Field(type: 'date')]
    #[Assert\NotBlank]
    private ?\DateTime $nascimento;

    #[MongoDB\Field(type: 'date')]
    private \DateTime $criacao_da_conta;

    #[MongoDB\Field(type: 'collection')]
    private array $roles;

    #[EmbedOne(targetDocument:TrocarSenha::class)]
    private ?TrocarSenha $trocar_senha = null;

    #[EmbedOne(targetDocument:ValidacaoDaConta::class)]
    private ?ValidacaoDaConta $validacao_da_conta = null;

    #[EmbedOne(targetDocument: Conteudos::class)]
    private ?Conteudos $conteudos = null;

    #[EmbedOne(targetDocument: Informacoes::class)]
    private ?Informacoes $informacoes = null;

    #[MongoDB\Field(type: 'bool')]
    private ?bool $selecionado;

    #

    public function getId()
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public function setUsername(string $username): void
    {
        $this->username = $username;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     *
     * @return array
     */
    public function getRoles(): array
    {
        $roles = $this->roles;

        return array_unique($roles);
    }

    /**
     * @param array $roles
     */
    public function setRoles(array $roles): static
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials(): void
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getAlcunha(): string
    {
        return $this->alcunha;
    }

    public function setAlcunha(string $alcunha): void
    {
        $this->alcunha = $alcunha;
    }

    public function getNomeCompleto(): string
    {
        return $this->nome_completo;
    }

    public function setNomeCompleto(string $nome_completo): void
    {
        $this->nome_completo = $nome_completo;
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function setStatus(string $status): void
    {
        $this->status = $status;
    }

    public function getCelular(): int
    {
        return $this->celular;
    }

    public function setCelular(int $celular): void
    {
        $this->celular = $celular;
    }

    public function getCriacaoDaConta(): \DateTime
    {
        //$criacao = DateTime::createFromFormat(\DateTimeInterface::ATOM, $this->criacao_da_conta);
        return $this->criacao_da_conta;
    }

    public function setCriacaoDaConta(\DateTime $criacao_da_conta): void
    {
        //$tt = $criacao_da_conta->format(\DateTimeInterface::ATOM);
        $this->criacao_da_conta = $criacao_da_conta;
    }

    public function getNascimento(): \DateTime
    {
        return $this->nascimento;
    }

    public function setNascimento(?\DateTime $nascimento): void
    {
        $this->nascimento = $nascimento;
    }

    public function getTrocarSenha(): ?TrocarSenha
    {
        if ($this->trocar_senha === null) {
            $this->trocar_senha = new TrocarSenha();
        }
        return $this->trocar_senha;
    }

    public function setTrocarSenha(?TrocarSenha $trocar_senha): void
    {
        $this->trocar_senha = $trocar_senha;

    }

    public function getValidacaoDaConta(): ?ValidacaoDaConta
    {
        if ($this->validacao_da_conta === null) {
            $this->validacao_da_conta = new ValidacaoDaConta();
        }
        return $this->validacao_da_conta;
    }

    public function setValidacaoDaConta(ValidacaoDaConta $validacao_da_conta): void
    {
        $this->validacao_da_conta = $validacao_da_conta;
    }

    public function getInformacoes(): ?Informacoes
    {
        if ($this->informacoes === null) {
            $this->informacoes = new Informacoes();
        }
        return $this->informacoes;
    }

    public function setInformacoes(Informacoes $informacoes): void
    {
        $this->informacoes = $informacoes;
    }

    public function getConteudosDaConta(): ?Conteudos
    {
        if ($this->conteudos === null) {
            $this->conteudos = new Conteudos();
        }
        return $this->conteudos;
    }

    public function setConteudosDaConta(Conteudos $conteudos): void
    {
        $this->conteudos = $conteudos;
    }

    public function getSelecionado(): bool
    {
        return isset($this->selecionado) ? $this->selecionado : false;
    }

    public function setSelecionado(bool $selecionado): void
    {
        $this->selecionado = $selecionado;
    }

}
