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
class StartCommand extends SystemCommand
{
    /**
     * @var string
     */
    protected $name = 'start';

    /**
     * @var string
     */
    protected $description = 'Start command';

    /**
     * @var string
     */
    protected $usage = '/start';

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
//        $text    = 'Hi there!' . PHP_EOL . 'Type /help to see all commands!';
        $text    = "به‌ مجله :blossom::hibiscus:جیک و پیک:hibiscus::blossom: کامل ترین ربات  مشاوره سلامتی و زیبایی خوش آمديد:person_with_blond_hair:🏻♀🧒🏼 (ویژه خانم ها و آقایان)"
                    .PHP_EOL."🧚♂مطالب توسط ‌تیمی از بهترين متخصصين ‌پوست، مو و‌ زیبایی تهیه شده است.🧚♀"
                    .PHP_EOL."پوست ويترين صورت شماست، اگر دغدغه پوست، سلامت و زيبايي خود را داريد, اگر داشتن پوست و صورتي زيبا خواسته ي هميشگي شماست، براي دانستن تمام اطلاعات زيبايي و پاسخ همه سوالات خود كافي است عضو مجله جيك و پيك شويد و مشاوره خود باشيد."
                    .PHP_EOL."براي استفاده از كليه امكانات ربات با وارد کردن دستور /register وارد شويد:rose:"
                    .PHP_EOL."هر ماه قرعه کشی گوشی آیفون :iphone:برای اعضای ویژه مجله:closed_book:"
                    .PHP_EOL."https://jikopeek.ir";

        $data = [
            'chat_id' => $chat_id,
            'text'    => $text,
        ];
        return Request::sendMessage($data);
    }
}
