<?php

class TransactionStatusEnum extends Enum
{
    const PENDING = 0;
    const PAID = 1;
    const IN_DISPUTE = 2;
    const REFUNDED = 3;
    const CANCELLED = 4;

    public static function getLabels()
    {
        return [
            self::PENDING => "pendente",
            self::PAID => "aprovado",
            self::IN_DISPUTE => "em disputa",
            self::REFUNDED => "estornado",
            self::CANCELLED => "cancelado",
        ];
    }
}
