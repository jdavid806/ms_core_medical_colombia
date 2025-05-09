<?php

namespace App\Helpers;

class InvoiceHelper
{
    public static function generateInvoiceCode($entity = 'RC')
    {
        $date = date('Ymd');

        $randomString = substr(str_shuffle('ABCDEFGHJKLMNPQRSTUVWXYZ23456789'), 0, 4);

        return "{$entity}-{$date}-{$randomString}";
    }
}
