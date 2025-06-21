<?php

namespace AlbyHubApi;

class albyHubClient extends albyHubApiMethodAbstract
{

    public function getSpendables() {
        $rs = $this->getBalances();
        return [
            'onchan' => $rs['onchain']['spendable'],
            'lightning' => $rs['lightning']['totalSpendable'],
        ];
    }
}



