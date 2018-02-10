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
        $text    = "به‌ مجله جیک و پیک کامل ترین ربات  مشاوره سلامتی و زیبایی خوش آمدید (ویژه خانم ها و آقایان)"
                    .PHP_EOL."مطالب توسط ‌تیمی از بهترین متخصصین ‌پوست، مو و‌ زیبایی تهیه شده است."
                    .PHP_EOL."پوست ویترین صورت شماست، اگر دغدغه پوست، سلامت و زیبایی خود را دارید، اگر داشتن پوست و صورتی زیبا خواسته ی همیشگی شماست، برای دانستن تمام اطلاعات زیبایی و پاسخ همه سوالات خود كافی است عضو مجله جیك و پیك شوید و مشاور خود باشید."
                    .PHP_EOL."برای استفاده از كلیه امكانات ربات با وارد کردن دستور /register وارد شوید."
                    .PHP_EOL."هر ماه قرعه کشی گوشی آیفون برای اعضای ویژه مجله"
                    .PHP_EOL."https://jikopeek.ir";

        $data = [
            'chat_id' => $chat_id,
            'text'    => $text,
        ];
        return Request::sendMessage($data);
    }
}
