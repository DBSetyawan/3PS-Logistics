<?php

namespace warehouse\Channels;

use GuzzleHttp\Client;
use Illuminate\Log\Logger;
use GuzzleHttp\Psr7\Request;
use Illuminate\Notifications\Notifiable;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Notifications\Notification;
use warehouse\Exceptions\WebHookFailedException;

class WebhookChannel
{
   
    private $logger;

    public function __construct(Client $client, Logger $logger)
    {
        $this->client = $client;
        $this->logger = $logger;
    }

    public function send($notifiable, Notification $notification)
    {
        if (method_exists($notification, 'toWebhook')) {
            $body = (array) $notification->toWebhook($notifiable);
        } else {
            $body = $notification->toArray($notifiable);
        }
        
        //testing mock
        $timestamp = now()->timestamp;
        $token = str_random(16);
        $headers = [
            'timestamp' => $timestamp,
            'token' => $token,
            'signature' => hash_hmac(
                'sha256',
                $token . $timestamp,
                $notifiable->getSigningKey()
            ),
        ];
        $request = new Request('POST', $notifiable->getWebhookUrl(), $headers, json_encode($body));
        try {
            $response = $this->client->send($request);
            if ($response->getStatusCode() !== 200) {
                throw new WebHookFailedException('Webhook received a non 200 response');
            }

            $this->logger->debug('Webhook successfully posted to '. $notifiable->getWebhookUrl());
            return;

        } catch (ClientException $exception) {

            if ($exception->getResponse()->getStatusCode() !== 410) {
                throw new WebHookFailedException($exception->getMessage(), $exception->getCode(), $exception);
            }

        } catch (GuzzleException $exception) {
            throw new WebHookFailedException($exception->getMessage(), $exception->getCode(), $exception);
        }


        $this->logger->error('Webhook failed in posting to '. $notifiable->getWebhookUrl());
    }
}