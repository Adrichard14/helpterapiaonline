<?php
    if(NL_PHPMAILER)
        include_once("phpmailer/class.phpmailer.php");
	class Newsletter {
		public static function email($mail, $type = "to") {
			$mails = is_array($mail) ? $mail : array($mail);
			$to = array();
			foreach($mails as $m)
                $to[] = array("email" => $m, "type" => $type);
			return $to;
		}
		public static function compose(array $inputs) {
            if(empty($inputs))
                return '';
            $output = $and = "";
            foreach($inputs as $name => $input) {
                $output.=$and.'<strong>'.$name.'</strong>: '.(is_array($input) && isset($input['URL']) ? '<a href="'.$input['URL'].'" target="_blank">'.$input['value'].'</a>' : (is_array($input) ? $input['value'] : $input));
                $and = "<br/>";
                if(is_array($input) && isset($input['end']) && $input['end'] != "")
                    $output.=$and.$input['end'];
            }
            return $output;
        }
        public static function run($emailIDs, $subject, $content) {
            $temp = explode(",", $emailIDs);
            $emailIDs = array();
            foreach($temp as $t)
                if(intval($t) > 0 && !in_array(intval($t), $emailIDs))
                    $emailIDs[] = intval($t);
            $emails = NewsletterEmail::load($emailIDs, NULL, NULL, 1);
            if(empty($emails))
                exit("Por favor, selecione algum e-mail ou atualize a página para verificar se o e-mail selecionado ainda está ativo.");
            $errors = array();
            foreach($emails as $em) {
                $footer = '<br/><p style="text-align: justify">Este é um boletim informativo da Neomentoring enviado para todos os e-mails cadastrados em nosso site. Se você não quer mais receber este tipo de contato neste endereço, por favor, <a href="'.PUBLIC_URL.'desativar-newsletter/'.$em['ID'].':'.$em['email'].'">clique aqui</a> ou copie o link abaixo e cole em seu navegador.</p>';
                $send = self::send($subject, $content.$footer, $em['email']);
                if(!$send)
                    $errors[] = $em['email'];
            }
            if(sizeof($errors) == sizeof($emails))
                exit("Houve algum problema e nenhum e-mail pôde receber esta mensagem. Por favor, entre em contato com um administrador.");
            elseif(sizeof($errors) > 0)
                exit(Display::Message("sc", "A mensagem foi enviada com sucesso, mas alguns e-mails não puderam receber esta mensagem. Os e-mails foram: <ul><li>".implode("</li><li>", $errors).'</li></ul>'));
            else
                exit(Display::Message("sc", "Mensagem enviada com sucesso!"));
        }
		public static function send($subject, $content, $to = "kaique@freedomdigital.com.br") {
            if(DISABLE_NEWSLETTER)
                return true;
            if(NL_PHPMAILER) {
                $mail           = new PHPMailer();
                $mail->IsSMTP();
                $mail->IsHTML(true);
                $mail->CharSet  = "UTF-8";
                $mail->SMTPAuth = true;
                $mail->Port     = NL_PORT;
                $mail->Host     = NL_HOST;
                $mail->Username = NL_USER;
                $mail->Password = NL_PASSWORD;
                $mail->From     = NL_FROM_MAIL;
                $mail->FromName = NL_FROM_NAME;
                $mail->SMTPDebug= 0;

                # ADDING MAILS /*
                if(!is_array($to))
                    $to = array($to);
                foreach($to as $to_) {
                    if(is_string($to_))
                        $mail->AddAddress($to_);
                    elseif(is_array($to_) && isset($to_['name'], $to_['mail']))
                        $mail->AddAddress($to_['mail'], $to_['name']);
                }
                #/ADDING MAILS */

                $mail->WordWrap = 50;
                $mail->Subject  = $subject;
                $mail->Body     = $content;
                return $mail->Send();
            } else {
                $headers  = 'MIME-Version: 1.0' . "\r\n";
                $headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";
                if(!is_array($to)) {
                    $to = array($to);
                }
                $destiny = array();
                foreach($to as $to_) {
                    if(is_string($to_)) {
                        $destiny[] = $to_;
                    } elseif(is_array($to_) && isset($to_['name'], $to_['mail'])) {
                        $destiny[] = $to_['name'].' <'.$to_['mail'].'>';
                    }
                }
                $to = implode(",", $destiny);
                $headers .= 'To: '.$to . "\r\n";
    //            $headers .= 'From: Kaique Garcia <kaiquegarciam@gmail.com>' . "\r\n";
                $headers .= 'From: '.NL_FROM_NAME.' <'.NL_FROM_MAIL.'>' . "\r\n";
                return mail($to, $subject, $content, $headers);
            }
		}
        public static function queue() {
            $left = NL_LIMIT_PH;
            $queues = Queue::load(-1, NULL, '`status` DESC, `execution_date` ASC, `registry_date` ASC', array(Queue::$STATUS_PENDENT, Queue::$STATUS_STARTED));
            if(empty($queues)) {
                exit("Empty queue.");
            }
            $i = 0;
            $now = strtotime(NOW);
            while($left > 0) {
                if(!isset($queues[$i]) || strtotime($queues[$i]['execution_date'].' 00:00:00') > $now) {
                    exit("Empty queue for now.");
                    break;
                }
                $queue = $queues[$i];
                if($queue['status'] == Queue::$STATUS_PENDENT) {
                    Queue::status($queue['ID'], Queue::$STATUS_STARTED, true);
                    $elem['status'] = Queue::$STATUS_STARTED;
                }
                $emails = QueueEmail::load(-1, '0,'.$left, NULL, QueueEmail::$STATUS_PENDENT, $queue['ID']);
                if(empty($emails)) {
                    Queue::status($queue['ID'], Queue::$STATUS_SENT, true);
                }
                $count = count($emails);
                foreach($emails as $email) {
                    $header = $queue['image'] != "" ? '<img src="'.PUBLIC_URL.$queue['image'].'" style="max-width: 100%; display: block;" />' : '';
                    $footer = '<p>Este é um boletim informativo automático de '.PROJECT_NAME.'. Se não deseja mais receber estes e-mails, <a href="'.PUBLIC_URL.'desativar/'.$email['emailID'].'/'.$email['email_value'].'">clique aqui</a>. Se o endereço não estiver funcionando, por favor, entre em contato conosco.</p>';
                    $send = self::send($queue['subject'], $header.$queue['content'].$footer, $email['email_value']);
                    if($send) {
                        QueueEmail::status($email['ID'], QueueEmail::$STATUS_SENT);
                    } else {
                        $count--;
                    }
                }
                if($count == count($emails)) { //100% sent
                    $has_left = QueueEmail::paginator(QueueEmail::$STATUS_PENDENT, $queue['ID']) > 0;
                    if(!$has_left) {
                        Queue::status($queue['ID'], Queue::$STATUS_SENT);
                    }
                }
                $left-=$count;
                $i++;
            }
        }
	}
?>