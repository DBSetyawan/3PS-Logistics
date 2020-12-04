<?php

namespace warehouse;

trait WebhookNotifiable
{
    public function getSigningKey()
    {
        return $this->api_key;
    }

    public function getWebhookUrl()
    {
        return $this->webhook_url;
    }

}