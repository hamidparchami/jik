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

use App\Content;
use App\Customer;
use Longman\TelegramBot\Commands\SystemCommand;
use Longman\TelegramBot\Entities\Keyboard;
use Longman\TelegramBot\Request;

/**
 * Start command
 */
class NextcontentCommand extends SystemCommand
{
    /**
     * @var string
     */
    protected $name = 'next content';

    /**
     * @var string
     */
    protected $description = 'Receive next content command';

    /**
     * @var string
     */
    protected $usage = '/nextcontent';

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

        /*$text = "اشتراک شما لغو شد و زین پس دیگر مطلبی دریافت نخواهید کرد.\n برای اشتراک مجدد دستور /register را وارد کنید.";

        $customer = Customer::where('account_id', $message->getFrom()->getId())->where('is_active', 1)->get()->first();
        if (is_null($customer)) {
            $text = "اشتراکی با این حساب کاربری یافت نشد!\n برای اطلاعات بیشتر دستور /support را وارد کنید.";
        } else {
            $customer->update(['is_active' => 0]);
        }*/

        $content = Content::inRandomOrder()->first();

        if ($content->type == 'photo') {
            $data    = [
                'chat_id'   => $chat_id,
                'photo'     => $content->photo_url,
                'caption'   => $content->text,
            ];
            return Request::sendPhoto($data);
        } elseif ($content->type == 'video') {
            $data    = [
                'chat_id'   => $chat_id,
                'video'     => $content->video_url,
                'caption'   => $content->text,
            ];
            return Request::sendVideo($data);
        } elseif ($content->type == 'text') {
            $data    = [
                'chat_id'   => $chat_id,
                'text'      => $content->text,
            ];
            return Request::sendMessage($data);
        }

        $data    = [
            'chat_id'       => $chat_id,
            'text'          => 'متاسفانه خطایی در دریافت اطلاعات رخ داده است لطفا دقایقی دیگر دوباره تلاش کنید.',
        ];
        return Request::sendMessage($data);
    }
}
