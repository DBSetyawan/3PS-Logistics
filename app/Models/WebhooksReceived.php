<?php

namespace warehouse\Models;

use Illuminate\Support\Facades\Cache;
use Illuminate\Database\Eloquent\Model as Eloquent;

/**
 * This file is part of CaptainHook arrrrr.
 *
 * @property integer id
 * @property integer tenant_id
 * @property string  event
 * @property string  url
 * @license MIT
 */
class WebhooksReceived extends Eloquent
{

    /**
     * Retrieve the logs for a given hook.
     *
     */
    public function lastLog()
    {
        return $this->hasOne('warehouse\Models\WebhooksLog')->orderBy('created_at', 'DESC');
    }

}
