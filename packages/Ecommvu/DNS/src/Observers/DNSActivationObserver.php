<?php

namespace Ecommvu\DNS\Observers;

use Ecommvu\DNS\Models\CompanySubscriptionPlan as Activation;
use AppStore;

class DNSActivationObserver
{
    public function updating(Activation $model)
    {
        if ($model->code == AppStore::getCode() && $model->status == 1) {
            dd('matched');
        }
    }
}