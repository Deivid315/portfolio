<?php

declare(strict_types=1);

namespace App\Security\AlterarDados;

use App\Repository\AlteracoesContaDb\AlterarDados;
use App\Security\Amazon\AwsS3\Cloud;
use App\Security\UserConfidential\Provider\UserProvider;
use App\Service\Email\EnviarEmailMailer;
use App\Service\Token\TokenGenerator;
use DateTime;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Session\Storage\Handler\MemcachedSessionHandler;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class AlteracoesNaConta
{

    public function __construct(
        private UserPasswordHasherInterface $passwordHasherInterface,
        private UserProvider $userProvider,
        private AlterarDados $alterarDados,
        private EnviarEmailMailer $envio,
        private TokenGenerator $token,
        private MemcachedSessionHandler $memcached,
        private RequestStack $requestStack,
        private Cloud $cloud
    ) {
    }

    public function alterarUsername(UserInterface $user, FormInterface $form): void
    {
        $flash = $this->requestStack->getSession()->getFlashbag();
        $username_novo = $form->getData()['username'];

        if ($username_novo === $user->getUsername()) {
            $flash->add('alerta', 'Seu novo username não pode ser igual ao seu username atual');
            return;
        }

        $alteracao_original = $user->getInformacoes()->getAlteracoes()->getAlteracaoUsername();
        if ($alteracao_original !== null) {
            $data_atual = new \DateTime();

            $intervalo = $data_atual->diff($alteracao_original);
            $dias = $intervalo->days;
            $horas = $intervalo->h;
            $minutos = $intervalo->i;

            $limite = 30;

            if ($dias <= $limite) {
                $dias_restantes = $limite - $dias;
                $horas_restantes = 23 - $horas;
                $minutos_restantes = 60 - $minutos;

                $msg = "Você alterou seu username há {$dias} dias, {$horas} horas e {$minutos} minutos atrás. ";
                $msg .= "Aguarde mais {$dias_restantes} dias, {$horas_restantes} horas e {$minutos_restantes} minutos para poder alterar novamente.";

                $flash->add('alerta', $msg);
                return;
            }
        }

        $dateTime = new DateTime();
        $user->getInformacoes()->getAlteracoes()->setAlteracaoUsername($dateTime);

        $resultado = $this->alterarDados->alterarUsername($username_novo, $user);

        if (!$resultado) {
            $user->getInformacoes()->getAlteracoes()->setAlteracaoUsername($alteracao_original);
            $flash->add('alerta', "Houve um problema durante a alteração do campo do username, tente novamente mais tarde");
        } else {
            $user->setUsername($username_novo);
            $flash->add('sucesso', "Alteração do username efetuada com sucesso para $username_novo");
        }
    }

    public function alterarEmail(UserInterface $user, FormInterface $form, TokenStorageInterface $token): void
    {
        $flash = $this->requestStack->getSession()->getFlashbag();
        $email_novo = $form->getData()['email'];

        if ($email_novo === $user->getEmail()) {
            $flash->add('alerta', 'Seu novo email não pode ser igual ao seu email atual');
            return;
        }

        $valid_origianl = $user->getValidacaoDaConta();

        $msg = $this->token->gereToken($email_novo, $user->getAlcunha());
        //
        $expiracao = new \DateTime();
        $data = new \DateTime();
        $user->getValidacaoDaConta()->setConfirmacaoDeEmail($data);
        $user->getValidacaoDaConta()->setChave($msg);
        $user->getValidacaoDaConta()->setStatus(false);

        $destrua = false;

        if (!$user->getInformacoes()->getEdicoesAtualizadas()->getStatus()) {
            if ($this->memcached->validateId($user->getId() . '_atualizacao')) {
                $destrua = true;
            }
        }

        $alteracao_email_original = $user->getInformacoes()->getAlteracoes()->getAlteracaoEmail();

        if ($alteracao_email_original !== null) {
            $data_atual = new \DateTime();

            $intervalo = $data_atual->diff($alteracao_email_original);
            $dias = $intervalo->days;
            $horas = $intervalo->h;
            $minutos = $intervalo->i;

            $limite = 30;

            if ($dias <= $limite) {
                $dias_restantes = $limite - $dias;
                $horas_restantes = 23 - $horas;
                $minutos_restantes = 60 - $minutos;

                $msg = "Você alterou seu email há {$dias} dias, {$horas} horas e {$minutos} minutos atrás. ";
                $msg .= "Aguarde mais {$dias_restantes} dias, {$horas_restantes} horas e {$minutos_restantes} minutos para poder alterar novamente.";

                $flash->add('alerta', $msg);
                return;
            }
        }

        $dateTime = new DateTime();
        $user->getInformacoes()->getAlteracoes()->setAlteracaoEmail($dateTime);

        $resultado = $this->alterarDados->buscarEmail($email_novo, $user, $user->getValidacaoDaConta(), $destrua);

        if (!$resultado) {
            $user->getInformacoes()->getAlteracoes()->setAlteracaoEmail($alteracao_email_original);
            $user->setValidacaoDaConta($valid_origianl);
            $flash->add('alerta', 'Houve um problema durante a alteração do seu email, tente novamente mais tarde');
            return;
        }

        $userId = $user->getId();

        if ($this->memcached->validateId($userId)) {
            $this->memcached->destroyEspecified($userId);
        }

        if ($destrua) {
            $this->memcached->destroyEspecified($user->getId() . '_atualizacao');
        }

        $html = '<p>Clique no link: <a href="localhost:8000/confirm/' . $msg . '">Confirmar Email</a> ou clique aqui: localhost:8000/confirm/' . $msg . '</p>';
        $this->envio->enviar($email_novo, 'Confirme sua conta agora!', $html);

        $flash->add('sucesso', 'Seu email foi alterado com sucesso.
                Você será desconectado da sua conta e será necessário acessar seu email atualizado
                e confirmar sua conta clicando no link');
        $token->setToken(null);
        return;
    }

    public function alterarSenha(UserInterface $user, FormInterface $form): void
    {
        $flash = $this->requestStack->getSession()->getFlashbag();
        $senha_atual = $form->getData()['senha_atual'];
        $senha_nova = $form->getData()['senha'];

        if (!$this->passwordHasherInterface->isPasswordValid($user, $senha_atual)) {

            $flash->add('alerta', 'Sua senha está incorreta');
            return;
        }

        if ($senha_atual === $senha_nova) {
            $flash->add('alerta', 'Sua senha atual não pode ser igual a senha nova');
            return;
        }

        $alteracao_senha_original = $user->getInformacoes()->getAlteracoes()->getAlteracaoSenha();

        $senha_nova_hash = $this->passwordHasherInterface->hashPassword($user, $senha_nova);

        if ($alteracao_senha_original !== null) {
            $data_atual = new \DateTime();

            $segundos = $data_atual->getTimestamp();
            $alterado = $alteracao_senha_original->getTimestamp();;
            $diferenca_segundos = $segundos - $alterado;
            $diferenca_horas = floor($diferenca_segundos / 3600); // Diferença em horas
            $diferenca_minutos = floor(($diferenca_segundos % 3600) / 60); // Diferença em minutos

            if ($diferenca_horas < 24) {
                $horas_restantes = 24 - $diferenca_horas;
                $minutos_restantes = 60 - $diferenca_minutos;
                $msg = "Você alterou sua senha há {$diferenca_horas} horas e {$diferenca_minutos} minutos atrás. Aguarde mais {$horas_restantes} horas e {$minutos_restantes} minutos para poder alterar novamente.";
                $flash->add('alerta', $msg);
                return;
            }
        }

        $resultado = $this->userProvider->upgradePassword($user, $senha_nova_hash);

        if (!$resultado) {
            $user->getInformacoes()->getAlteracoes()->setAlteracaoSenha($alteracao_senha_original);
            $flash->add('alerta', 'Houve um problema durante o salvamento da sua senha, tente novamente mais tarde');
            return;
        }
        $flash->add('sucesso', 'Senha alterada com sucesso');
        return;
    }

    public function alterarDadoEspecifico(UserInterface $user, FormInterface $form, string $dado): void
    {
        $novo_dado = $form->getData()[$dado];
        $flash = $this->requestStack->getSession()->getFlashbag();

        $getter = 'get' . ucfirst($dado);
        $setter = 'set' . ucfirst($dado);
        $getterAlteracao = 'getAlteracao' . ucfirst($dado);
        $setterAlteracao = 'setAlteracao' . ucfirst($dado);

        if ($dado === 'celular') {
            $novo_dado = intval($novo_dado);
        }
        if ($novo_dado === $user->$getter()) {
            $flash->add('alerta', ucfirst($dado) . ' atual não pode ser igual ao novo ' . $dado);
            return;
        }

        $alteracao_original = $user->getInformacoes()->getAlteracoes()->$getterAlteracao();
        if ($alteracao_original !== null) {
            $data_atual = new \DateTime();

            $intervalo = $data_atual->diff($alteracao_original);
            $dias = $intervalo->days;
            $horas = $intervalo->h;
            $minutos = $intervalo->i;

            $limite = 30;
            if ($dado === 'nascimento') {
                $limite = 90;
            }

            if ($dias <= $limite) {
                $dias_restantes = $limite - $dias;
                $horas_restantes = 23 - $horas;
                $minutos_restantes = 60 - $minutos;

                $msg = "Você alterou seu(a) {$dado} há {$dias} dias, {$horas} horas e {$minutos} minutos atrás. ";
                $msg .= "Aguarde mais {$dias_restantes} dias, {$horas_restantes} horas e {$minutos_restantes} minutos para poder alterar novamente.";

                $flash->add('alerta', $msg);
                return;
            }
        }

        $dateTime = new DateTime();
        $user->getInformacoes()->getAlteracoes()->$setterAlteracao($dateTime);

        $resultado = $this->alterarDados->alteracaoDinamica($dado, $novo_dado, $user, $getterAlteracao);

        if (!$resultado) {
            $user->getInformacoes()->getAlteracoes()->$setterAlteracao($alteracao_original);
            $flash->add('alerta', "Houve um problema durante a alteração do campo {$dado}, tente novamente mais tarde");
        } else {
            $user->$setter($dado === 'celular' ? intval($novo_dado) : $novo_dado);
            $flash->add('sucesso', "Alteração do campo {$dado} efetuada com sucesso");
        }
    }

    public function apagarNotificacoes(UserInterface $user): void
    {
        $resultado = $this->alterarDados->apagarNotificacoesBd($user);

        if (!$resultado) {
            $msg =  'Houve um problema durante a deleção das suas notificações, tente novamente mais tarde';
            $this->requestStack->getSession()->getFlashbag()->add('alerta', $msg);
        } else {
            $user->getConteudosDaConta()->setNotificacoes(null);
            $this->requestStack->getSession()->getFlashbag()->add('sucesso', 'Notificações apagadas com sucesso');
        }
    }

    public function offOnConta(UserInterface $user, string $status): void
    {
        $resultado = $this->alterarDados->offOnContaDb($user, $status);

        if (!$resultado) {
            $msg =  "Houve um problema durante o processo de
            deixar usa conta {$status}, tente novamente mais tarde";
            $this->requestStack->getSession()->getFlashbag()->add('alerta', $msg);
        } else {
            //$variavel = Uuid::uuid4()->toString() . hash('SHA1', $user->getId());
            $user->setStatus($status);
            $this->requestStack->getSession()->getFlashbag()->add('sucesso', "O processo de deixar
             sua conta {$status} foi realizado com sucesso!");
            //$this->cloud->suspenderContaAws($user, $status, $variavel);
        }
    }

    public function deletarConta(FormInterface $form, UserInterface $user, TokenStorageInterface $token): void
    {
        $senha = $form->getData()['senha'];

        if (!$this->passwordHasherInterface->isPasswordValid($user, $senha)) {
            $this->requestStack->getSession()->getFlashbag()->add('alerta', "Sua senha está incorreta");
            return;
        }

        $this->cloud->deletarContaAws($user);
        $resultado = $this->alterarDados->deletarContaDb($user);

        if ($resultado) {
            $this->requestStack->getSession()->getFlashbag()->add('sucesso', "Conta deletada, adeus");
            $token->setToken(null);
        } else {
            $this->requestStack->getSession()->getFlashbag()->add('alerta', "Houve um erro 
            durante o processo de deletar sua conta, tente novamente mais tarde");
        }
    }
}
