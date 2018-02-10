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
use Carbon\Carbon;
use Longman\TelegramBot\Commands\SystemCommand;
use Longman\TelegramBot\Request;

/**
 * Start command
 */
class ScoreCommand extends SystemCommand
{
    /**
     * @var string
     */
    protected $name = 'score';

    /**
     * @var string
     */
    protected $description = 'Get customer score command';

    /**
     * @var string
     */
    protected $usage = '/score';

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

        $customer = Customer::where('account_id', $message->getFrom()->getId())->where('is_active', 1)->get()->first();
        if (is_null($customer)) {
            $text = "اشتراکی با این حساب کاربری یافت نشد!".PHP_EOL." برای اطلاعات بیشتر دستور /support را وارد کنید.";
        } else {
            $customer_registration_days = Carbon::parse($customer->created_at);
            $customer_registration_days = $customer_registration_days->diffInDays(Carbon::now());
            $customer_score = $customer_registration_days*20;

            $text = "تبریک میگم".
                    PHP_EOL.sprintf("با ‌توجه به اینکه شما %d روز است که مشترک ویژه مجله جیک و پیک هستید امتیاز شما ‌برای برنده شدن در‌ قرعه کشی ماهانه یک گوشی‌ آیفون و جایزه ویژه نوروز سفر به کشور تایلند  برابر %d میباشد.".PHP_EOL."(نسخه آزمایشی)", $customer_registration_days, $customer_score);
        }

        $data    = [
            'chat_id'      => $chat_id,
            'text'         => $text,
        ];
        return Request::sendMessage($data);
    }
}
