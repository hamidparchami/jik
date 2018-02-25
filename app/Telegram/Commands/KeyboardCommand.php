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

use App\Customer;
use Longman\TelegramBot\Commands\SystemCommand;
use Longman\TelegramBot\Entities\Keyboard;
use Longman\TelegramBot\Request;

/**
 * Keyboard command
 *
 * Gets executed when any type of message is sent.
 */
class KeyboardCommand extends SystemCommand
{
    /**
     * @var string
     */
    protected $name = 'keyboard';
    /**
     * @var string
     */
    protected $description = 'display keyboard';

    /**
     * @var string
     */
    protected $usage = '/keyboard';

    /**
     * @var string
     */
    protected $version = '1.0.0';
    /**
     * @var bool
     */
//    protected $need_mysql = true;
    /**
     * Command execute method if MySQL is required but not available
     *
     * @return \Longman\TelegramBot\Entities\ServerResponse
     * @throws \Longman\TelegramBot\Exception\TelegramException
     */
    public function executeNoDb()
    {
        // Do nothing
        return Request::emptyResponse();
    }
    /**
     * Command execute method
     *
     * @return \Longman\TelegramBot\Entities\ServerResponse
     * @throws \Longman\TelegramBot\Exception\TelegramException
     */
    public function execute()
    {
        $message = $this->getMessage();
        $chat_id = $message->getChat()->getId();

        $keyboard = new Keyboard(
            [ "\xE2\x9D\xA4 مدیریت علاقه‌مندی‌ها", "\xE2\x9E\xA1 مشاهده مطالب مجله"],
            ["\xF0\x9F\x9A\xAB لغو اشتراک", "\xF0\x9F\x92\xB0 امتیاز من"]
        );
        $keyboard->setResizeKeyboard(true);
        $text = 'یکی از عملیات های زیر را انتخاب کنید:';

        $customer = Customer::where('account_id', $message->getFrom()->getId())->where('is_active', 1)->get()->first();
        if (is_null($customer)) {
            return $this->getTelegram()->executeCommand('register');
        }

        $data = [
            'chat_id' => $chat_id,
            'text'    => $text,
            'reply_markup' => $keyboard,
        ];
        return Request::sendMessage($data);
    }
}
