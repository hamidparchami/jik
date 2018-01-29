<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Longman\TelegramBot\Exception\TelegramException;
use Longman\TelegramBot\Telegram;

class TelegramSetWebhook extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'telegram:setWebhook';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sets telegram webhook';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        // Add you bot's API key and name
        $bot_api_key  = config('telegram.api_key');
        $bot_username = config('telegram.username');
        // Define the URL to your hook.php file
        $hook_url     = config('telegram.webhook_url');
        try {
            // Create Telegram API object
            $telegram = new Telegram($bot_api_key, $bot_username);
            // Set webhook
            $result = $telegram->setWebhook($hook_url);
            // To use a self-signed certificate, use this line instead
            //$result = $telegram->setWebhook($hook_url, ['certificate' => $certificate_path]);
            if ($result->isOk()) {
                $this->info($result->getDescription());
            }
        } catch (TelegramException $e) {
            $this->error($e->getMessage());
        }
    }
}
