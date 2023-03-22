<?php 

namespace DXL\Classes\Discord;

if ( ! defined('ABSPATH') ) {
  exit;
}

if ( ! class_exists('DiscordWebhookService') ) {
  /**
   * Discord Webhook Service
   */
  class DiscordWebhookService {
    /**
     * Discord Webhook URL
     *
     * @var string
     */
    private $webhook_url;

    /**
     * Discord Webhook Service constructor
     *
     * @param string $webhook_url
     */
    public function __construct($webhook_url) {
      $this->webhook_url = $webhook_url;
    }

    /**
     * Send message to Discord Webhook
     *
     * @param string $message
     * @return void
     */
    public function send_message($message) {
      $data = [
        'content' => $message
      ];

      $this->send($data);
    }

    /**
     * Send embed to Discord Webhook
     *
     * @param array $embed
     * @return void
     */
    public function send_embed($embed) {
      $data = [
        'embeds' => [$embed]
      ];

      $this->send($data);
    }

    /**
     * Send data to Discord Webhook
     *
     * @param array $data
     * @return void
     */
    private function send($data) {
      $curl = curl_init($this->webhook_url);
      curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'POST');
      curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data));
      curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
      curl_setopt($curl, CURLOPT_HTTPHEADER, [
        'Content-Type: application/json',
        'Content-Length: ' . strlen(json_encode($data))
      ]);

      $result = curl_exec($curl);
      curl_close($curl);
    }
  }
} 