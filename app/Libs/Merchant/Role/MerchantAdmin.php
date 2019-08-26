<?php

namespace App\Libs\Merchant\Role;

use App\Libs\Merchant\BaseMerchant;
class MerchantAdmin extends BaseMerchant
{
    protected function calculateCredit($value)
    {
        return 0;
    }

    protected function getRateCompany($rate_company)
    {
        return FALSE;
    }

    protected function parentDecrementBalance($value)
    {
        return 0;
    }

    protected function parentRebates()
    {
        return [];
    }
}