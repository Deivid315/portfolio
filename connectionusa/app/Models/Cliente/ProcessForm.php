<?php

namespace App\Models\Cliente;

use CodeIgniter\Model;
use DateTime;
use DateTimeZone;

class ProcessForm extends Model
{
    public function envie(string $email, string $nome, int $telefone, string $informacoes): ?array
    {
        try {

            $emailService = service('email');

            $dataEnvio = new DateTime('now', new DateTimeZone('America/Sao_Paulo'));
            
            $formattedDataEnvio = $dataEnvio->format('d/m/Y');
            $formattedHoraEnvio = $dataEnvio->format('H:i:s');

            $mensagem = "
                <html>
                <meta charset='UTF-8'>
                <body>
                    <table width='510' border='1' cellpadding='1' cellspacing='1' bgcolor='#CCCCCC'>
                        <tr>
                            <td>
                                <tr>
                                    <td width='500'>Nome: " . esc($nome) . "</td>
                                </tr>
                                <tr>
                                    <td width='320'>E-mail: <b>" . esc($email) . "</b></td>
                                </tr>
                                <tr>
                                    <td width='320'>Telefone: <b>" . esc($telefone) . "</b></td>
                                </tr>
                                <tr>
                                    <td width='320'>Tópico: <b>" . esc($informacoes) . "</b></td>
                                </tr>
                            </td>
                        </tr>
                        <tr>
                            <td>Este e-mail foi enviado em <b>" . esc($formattedDataEnvio) . "</b> às <b>" . esc($formattedHoraEnvio) . "</b></td>
                        </tr>
                    </table>
                </body>
                </html>
            ";

            $emailService->setTo('contato@magnossites.com');
            $emailService->setSubject('Formulário de Contato');
            $emailService->setMessage($mensagem);

            if (!$emailService->send()) {
                $error = $emailService->printDebugger(['headers', 'subject', 'body']);
                log_message('error', 'Erro ao enviar email: ' . $error);
                return ['msg' => 'Não foi possível enviar seu e-mail, tente novamente mais tarde.', 'cor' => 'red'];
            }

            return ['msg' => 'E-mail enviado com sucesso!', 'cor' => 'green'];
            
        } catch (\Throwable $e) {

            return ['msg' => 'Houve um erro em nossos serviços, tente novamente mais tarde.', 'cor' => 'red'];
        }
    }
}
