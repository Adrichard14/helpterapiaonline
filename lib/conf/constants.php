<?php

define('PROJECT_NAME', 'HELP Terapia Online');

// PagSeguro: PLANOS
define('PAGSEGURO_TRANSACTION_EMAIL', 'helpterapia@gmail.com');
define('PAGSEGURO_TRANSACTION_PRODUCTION_TOKEN',
    '50900f73-9255-448f-9122-350867f3b4b30b08f922498cb42aab46d995c864fcd1645b-5bee-47b0-a38f-8a32e48b402b');
define('PAGSEGURO_TRANSACTION_SANDBOX_TOKEN',
    '50900f73-9255-448f-9122-350867f3b4b30b08f922498cb42aab46d995c864fcd1645b-5bee-47b0-a38f-8a32e48b402b');

// PagSeguro: AGENDAMENTOS
define('PAGSEGURO_TRANSACTION_APPOINTMENT_EMAIL', 'helpterapiaonline@gmail.com');
define('PAGSEGURO_TRANSACTION_APPOINTMENT_PRODUCTION_TOKEN',
    'bfd9d68d-e949-428a-9302-687039b7176b5144c01547ae90a9f21d7c685da411677ff9-56a1-47c4-ab9e-19bcf72d88a6');
define('PAGSEGURO_TRANSACTION_APPOINTMENT_SANDBOX_TOKEN', '');


define('PAGSEGURO_ENV', TEST_MODE ? 'sandbox' : 'production');
define('PAGSEGURO_TRANSACTION_TOKEN',
    TEST_MODE ? PAGSEGURO_TRANSACTION_SANDBOX_TOKEN : PAGSEGURO_TRANSACTION_PRODUCTION_TOKEN);
define('PAGSEGURO_TRANSACTION_APPOINTMENT_TOKEN',
    TEST_MODE ? PAGSEGURO_TRANSACTION_APPOINTMENT_SANDBOX_TOKEN : PAGSEGURO_TRANSACTION_APPOINTMENT_PRODUCTION_TOKEN);
