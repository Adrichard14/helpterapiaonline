<?php
	require_once("lib/classes/Package.php");
	new Package();
    libxml_use_internal_errors(true);
    function quit($txt = "") {
        exit('<script>'.($txt != "" ? 'alert("'.utf8_decode($txt).'");' : "").'location.href="'.PUBLIC_URL.'";</script>');
    }
	Page::Load($language);
    function prepareDOM($HTML) {
        if($HTML == "")
            return "";
        $doc = new DOMDocument();
        $doc->strickErrorChecking = false;
        $doc->loadHTML($HTML);
        return $doc->saveHTML();
    }
    exit();
?>
<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title><?php echo PROJECT_NAME; ?> - em manutenção</title>
        <meta name="author" content="Freedom Digital" />
        <style>
            body {
                background-color: #575757;
                width: 100%;
                height: 100%;
            }
            div {
                width: 100%;
                max-width: 300px;
                height: auto;
                position: absolute;
                top: 50%;
                left: 50%;
                transform: translate(-50%, -50%);
                background-color: #f8f8f8;
                color: #575757;
                padding: 15px;
                border-radius: 25px;
                text-align: center;
                border: 2px dashed #10b3da;
            }
            div p {
                text-align: justify;
            }
            div img {
                max-width: 100%;
            }
        </style>
    </head>
    <body>
        <div>
            <img src="manutencao.png" />
            <h1>Em manutenção!</h1>
            <p>No momento, nosso site está sendo atualizado para uma versão mais recente. Sentimos muito pelo transtorno, em breve retornaremos com algumas mudanças!</p>
        </div>
    </body>
</html>