<?php

namespace core\classes;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

class EnviarEmail{

    // ===============================================================
    public function enviar_email_confirmacao_novo_cliente($email_cliente, $purl){

        // envia um email para o novo cliente no sentido de confirmar o email

        // constroi o purl (link para validação do email)
        $link = BASE_URL . '?a=confirmar_email&purl='.$purl;

        $mail = new PHPMailer(true);

        try {

            // opções do servidor
            $mail->SMTPDebug = SMTP::DEBUG_OFF;
            $mail->isSMTP();
            $mail->Host       = EMAIL_HOST;
            $mail->SMTPAuth   = true;
            $mail->Username   = EMAIL_FROM;
            $mail->Password   = EMAIL_PASS;
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port       = EMAIL_PORT;
            $mail->CharSet    = 'UTF-8';

            // emissor e recetor
            $mail->setFrom(EMAIL_FROM, APP_NAME);
            $mail->addAddress($email_cliente);

            // assunto
            $mail->isHTML(true);
            $mail->Subject = APP_NAME . ' - Confirmação de email.';
            
            // mensagem
            $html = '<p>Seja bem-vindo à nossa loja ' . APP_NAME . '.</p>';
            $html .= '<p>Para poder entrar na nossa loja, necessita confirmar o seu email.</p>';
            $html .= '<p>Para confirmar o email, click no link abaixo:</p>';
            $html .= '<p><a href="'.$link.'">Confirmar Email</a></p>';
            $html .= '<p><i><small>' . APP_NAME .'</small></i></p>';

            $mail->Body = $html;

            $mail->send();
            return true;
        } catch (Exception $e) {
            return false;
        }
    }

    // ===============================================================
    public function enviar_email_confirmacao_encomenda($email_cliente, $dados_encomenda){

        // envia um email para o novo cliente no sentido de confirmar o email

        $mail = new PHPMailer(true);

        try {

            // opções do servidor
            $mail->SMTPDebug = SMTP::DEBUG_OFF;
            $mail->isSMTP();
            $mail->Host       = EMAIL_HOST;
            $mail->SMTPAuth   = true;
            $mail->Username   = EMAIL_FROM;
            $mail->Password   = EMAIL_PASS;
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port       = EMAIL_PORT;
            $mail->CharSet    = 'UTF-8';

            // emissor e recetor
            $mail->setFrom(EMAIL_FROM, APP_NAME);
            $mail->addAddress($email_cliente);

            // assunto
            $mail->isHTML(true);
            $mail->Subject = APP_NAME . ' - Confirmação de encomenda - ' . $dados_encomenda['dados_pagamento']['codigo_encomenda'];
            
            // mensagem
            $html = '<p>Este email serve para confirmar a sua encomenda.</p>';
            $html .= '<p>Dados da encomenda:</p>';
            
            // lista dos produtos
            $html .= '<ul>';
            foreach($dados_encomenda['lista_produtos'] as $produto){
                $html .= "<li>$produto</li>";
            }
            $html .= '</ul>';

            // total
            $html .= '<p>Total: <strong>' . $dados_encomenda['total'] . '</strong></p>';

            // dados de pagamento
            $html .= '<hr>';
            $html .= '<p>DADOS DE PAGAMENTO:</p>';
            $html .= '<p>Número da conta: <strong>'.$dados_encomenda['dados_pagamento']['numero_da_conta'].'</strong></p>';
            $html .= '<p>Código da encomenda: <strong>'.$dados_encomenda['dados_pagamento']['codigo_encomenda'].'</strong></p>';
            $html .= '<p>Valor a pagar: <strong>'.$dados_encomenda['dados_pagamento']['total'].'</strong></p>';
            $html .= '<hr>';

            // nota importante
            $html .= '<p>NOTA: A sua encomenda só será processada após pagamento.</p>';
            $html .= '<p>Para confirmar o pagamento deve mandar o comprovativo da transferência pelo whatsapp do seguinte numero</p>';
            $html .= '<p>+244 938 743 129 </p>';

            $mail->Body = $html;

            $mail->send();
            return true;
        } catch (Exception $e) {
            return false;
        }
    }

    // ===============================================================
    public function enviar_pdf_encomenda_para_cliente($email_cliente, $ficheiro)
    {
        $mail = new PHPMailer(true);

        try {

            // opções do servidor
            $mail->SMTPDebug = SMTP::DEBUG_OFF;
            $mail->isSMTP();
            $mail->Host       = EMAIL_HOST;
            $mail->SMTPAuth   = true;
            $mail->Username   = EMAIL_FROM;
            $mail->Password   = EMAIL_PASS;
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port       = EMAIL_PORT;
            $mail->CharSet    = 'UTF-8';

            // emissor e recetor
            $mail->setFrom(EMAIL_FROM, APP_NAME);
            $mail->addAddress($email_cliente);

            // assunto
            $mail->isHTML(true);
            $mail->Subject = APP_NAME . ' - envio do pdf com os detalhes da compra.';

            // ficheiro
            $mail->addAttachment(PDF_PATH . $ficheiro);

            // mensagem
            $html = '<p> Sua encomenda encontra-se em processamento.</p>';
            $html .= '<p>Segue em anexo pdf com os detalhes da sua compra </p>';
            $html .= '<p><i><small>' . APP_NAME .'</small></i></p>';

            $mail->Body = $html;

            $mail->send();
            return true;
        } catch (Exception $e) {
            return false;
        }
    }
 
    
}