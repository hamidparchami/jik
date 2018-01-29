<?php
/**
 * This file is part of the TelegramBot package.
 *
 * (c) Avtandil Kikabidze aka LONGMAN <akalongman@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Longman\TelegramBot\Commands\SystemCommands;

use Longman\TelegramBot\Commands\SystemCommand;
use Longman\TelegramBot\Request;

/**
 * Start command
 */
class HelpCommand extends SystemCommand
{
    /**
     * @var string
     */
    protected $name = 'help';

    /**
     * @var string
     */
    protected $description = 'Help command';

    /**
     * @var string
     */
    protected $usage = '/help';

    /**
     * @var string
     */
    protected $version = '1.0.0';

    /**
     * Command execute method
     *
     * @return mixed
     * @throws \Longman\TelegramBot\Exception\TelegramException
     */
    public function execute()
    {
        $message = $this->getMessage();
        $chat_id = $message->getChat()->getId();
        $text    = 'راهنما: ' . PHP_EOL . 'در این بات شما بصورت روزانه مطالب مختلفی دریافت می کنید. برای دریافت مطالب شخصی سازی شده می بایست اکانت ویژه خریداری کنید.'.PHP_EOL.'/register';
        $data = [
            'chat_id' => $chat_id,
            'text'    => $text,
        ];
        return Request::sendMessage($data);
    }
}
