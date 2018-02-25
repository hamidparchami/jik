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
 * Start command
 */
class RevokeCommand extends SystemCommand
{
    /**
     * @var string
     */
    protected $name = 'revoke';

    /**
     * @var string
     */
    protected $description = 'Revoke command';

    /**
     * @var string
     */
    protected $usage = '/revoke';

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

        $text = "اشتراک شما لغو شد و زین پس دیگر مطلبی دریافت نخواهید کرد.\n برای اشتراک مجدد دستور /register را وارد کنید.";

        $customer = Customer::where('account_id', $message->getFrom()->getId())->where('is_active', 1)->get()->first();
        if (is_null($customer)) {
//            $text = "اشتراکی با این حساب کاربری یافت نشد!\n برای اطلاعات بیشتر دستور /support را وارد کنید.";
            $text = "اشتراکی با این حساب کاربری یافت نشد!";
        } else {
            $customer->update(['is_active' => 0]);
        }

        //(bots version 2.0)
        $keyboard = new Keyboard([
            ['text' => '\xF0\x9F\x91\x88 ثبت شماره تلفن \xF0\x9F\x91\x89', 'request_contact' => true],
        ]);

        $keyboard->setResizeKeyboard(true);

        $data    = [
            'chat_id'      => $chat_id,
            'text'         => $text,
            'reply_markup' => $keyboard,
        ];
        return Request::sendMessage($data);
    }
}
