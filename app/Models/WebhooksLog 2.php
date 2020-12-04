<?php

namespace warehouse\Models;

use warehouse\Models\WebhooksReceived;
use Illuminate\Database\Eloquent\Model as Eloquent;

/**
 * This file is part of CaptainHook arrrrr.
 *
 * @license MIT
 */
class WebhooksLog extends Eloquent
{

    protected $table = 'webhook_logs';
    /**
     * Make the fields fillable.
     *
     * @var array
     */
    protected $fillable = ['webhook_id', 'url', 'payload_format', 'payload', 'status', 'response', 'response_format'];

    // protected 
    protected $casts = [
        'response' => 'array'
    ];

    /**
     * Retrieve the webhook described by the log.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function webhook()
    {
        return $this->belongsTo('warehouse\Models\WebhooksReceived');
    }
}
