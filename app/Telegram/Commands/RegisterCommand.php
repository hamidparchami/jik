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
use Longman\TelegramBot\Entities\Keyboard;
use Longman\TelegramBot\Request;

/**
 * Start command
 */
class RegisterCommand extends SystemCommand
{
    /**
     * @var string
     */
    protected $name = 'register';

    /**
     * @var string
     */
    protected $description = 'Register command';

    /**
     * @var string
     */
    protected $usage = '/register';

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

        //(bots version 2.0)
        $keyboard = new Keyboard([
            ['text' => 'ثبت شماره تلفن', 'request_contact' => true],
//            ['text' => 'Send my location', 'request_location' => true],
        ]);
        //Return a random keyboard.
        $keyboard->setResizeKeyboard(true)
                    ->setOneTimeKeyboard(true)
                    ->setSelective(false);

        $data    = [
            'chat_id'      => $chat_id,
            'text'         => 'برای ثبت نام در مجله، کلید زیر (ثبت شماره تلفن) را لمس کرده و سپس OK را انتخاب نمایید:',
            'reply_markup' => $keyboard,
        ];
        return Request::sendMessage($data);
    }
}
