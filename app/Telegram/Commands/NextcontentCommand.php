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
use App\CustomerCategory;
use App\CustomerReceivedContent;
use Longman\TelegramBot\Commands\SystemCommand;
use Longman\TelegramBot\Entities\InlineKeyboard;
use Longman\TelegramBot\Entities\InlineKeyboardButton;
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
        $message        = $this->getMessage();
        $chat_id        = $message->getChat()->getId();
        $customer_id    = $message->getFrom()->getId();

        /*$text = "اشتراک شما لغو شد و زین پس دیگر مطلبی دریافت نخواهید کرد.\n برای اشتراک مجدد دستور /register را وارد کنید.";

        $customer = Customer::where('account_id', $message->getFrom()->getId())->where('is_active', 1)->get()->first();
        if (is_null($customer)) {
            $text = "اشتراکی با این حساب کاربری یافت نشد!\n برای اطلاعات بیشتر دستور /support را وارد کنید.";
        } else {
            $customer->update(['is_active' => 0]);
        }*/


        //get customer categories
        $customer_categories = CustomerCategory::where('customer_id', $customer_id)->get(['category_id'])->implode('category_id', ',');

        if (count($customer_categories) == 0 || strlen($customer_categories) == 0) {
            //then warn customer to select at least one category
            $command = "favoritecategories";
            $text = "برای استفاده از امکانات ابتدا علاقه‌مندی‌هات رو از طریق زیر مشخص کن.";
            $data = [
                'chat_id' => $chat_id,
                'text'    => $text,
            ];

            Request::sendMessage($data);

            return $this->getTelegram()->executeCommand($command);
        }

        if(strpos($customer_categories, ',')) {
            $customer_categories = explode(',', $customer_categories);
        } else {
            $customer_categories = str_split($customer_categories, 1);
        }

        //get 1. content with customer categories 2. customer has not got it yet 3. order by order asc
        $service_id = 1; //@TODO make it dynamic
        $customer_received_contents = CustomerReceivedContent::where('customer_id', $customer_id)
                                                                ->get(['content_id'])
                                                                ->implode('content_id', ',');
        //$customer_received_contents = explode(',', $customer_received_contents);
 	    if(strpos($customer_received_contents, ',')) {
            $customer_received_contents = explode(',', $customer_received_contents);
        } else {
            $customer_received_contents = array($customer_received_contents);
        }

        $content_in_categories = Content::where('service_id', $service_id)
                                            ->whereIn('category_id', $customer_categories)
                                            ->whereNotIn('id', $customer_received_contents)
                                            ->where('is_active', '1')
                                            ->get(['category_id'])
                                            ->implode('category_id', ',');

 	    //when there is no more contents
        if (count($content_in_categories) == 0 || strlen($content_in_categories) == 0) {
            $text   = "مطلب جدیدی در موضوعات مورد علاقه شما وجود نداره. بزودی مطالب جدید به این موضوعات افزوده میشه. برای دریافت مطالب قبلی کلید «\xF0\x9F\x9A\xAB حذف تاریخچه» و یا برای انتخاب موضوعات دیگه دکمه            «\xE2\x9D\xA4 مدیریت علاقه‌مندی‌ها» رو بزن.".PHP_EOL;
            $text  .= "دقت داشته باش که با حذف تاریخچه، مطالبی که قبلا دریافت کردی رو هم دوباره از ابتدا دریافت میکنی.".PHP_EOL;

            $inline_keyboard_options = [];
            array_push($inline_keyboard_options, new InlineKeyboardButton(['text' => "\xE2\x9D\xA4 مدیریت علاقه‌مندی‌ها", 'callback_data' => 'favoritecategories_display']));
            array_push($inline_keyboard_options, new InlineKeyboardButton(['text' => "\xF0\x9F\x9A\xAB حذف تاریخچه", 'callback_data' => 'history_clear']));

            $inline_keyboard = new InlineKeyboard(...$inline_keyboard_options);
            $inline_keyboard->setResizeKeyboard(true);

            $data = [
                'chat_id'      => $chat_id,
                'text'         => $text,
                'reply_markup' => $inline_keyboard,
            ];
            return Request::sendMessage($data);
        }

        if(strpos($content_in_categories, ',')) {
            $content_in_categories = explode(',', $content_in_categories);
        } else {
//            $content_in_categories[] = $content_in_categories[0];
            $content_in_categories = str_split($content_in_categories, 1);
        }

        $category_to_query = array_rand($content_in_categories, 1);

        //query for a new content that customer has not received yet
        $content = Content::where('service_id', $service_id)
                            ->where('category_id', $content_in_categories[$category_to_query])
			                ->whereNotIn('id', $customer_received_contents)
                            ->where('is_active', '1')
                            ->orderBy('order', 'asc')
                            ->get()
                            ->first();
        //if there is an available content
        if (!is_null($content)) {
            //log customer received content
            CustomerReceivedContent::firstOrCreate(['customer_id' => $customer_id, 'content_id' => $content->id]);
            if ($content->type == 'photo') {
                $header = "@jikopeek_bot".PHP_EOL;
                $data = [
                    'chat_id'   => $chat_id,
                    'photo'     => $content->photo_url,
                    'caption'   => $header.$content->text,
                ];
                return Request::sendPhoto($data);

            } elseif ($content->type == 'video') {
                $header = "@jikopeek_bot".PHP_EOL;
                $data = [
                    'chat_id'   => $chat_id,
                    'video'     => $content->video_url,
                    'caption'   => $header.$content->text,
                ];
                return Request::sendVideo($data);

            } elseif ($content->type == 'text') {
                $header = "\xF0\x9F\x8C\xB9 	با لمس \xF0\x9F\x91\x88 @jikopeek_bot \xF0\x9F\x91\x89 عضو مجله سلامت جیک و پیک شده و در‌ قرعه کشی های ماهانه‌ ما برنده جوایز نفیس شوید. \xF0\x9F\x8C\xB9".PHP_EOL."--------------------".PHP_EOL;
                $text = $header.$content->text;
                if ($content->show_instant_view) {
                    $text .= PHP_EOL . sprintf("محتوای کامل را در Instant View ببینید: "." https://t.me/iv?url=%s/%d&rhash=e6f66e7d26291d", url('/content/'), $content->id);
                }

                $data = [
                    'chat_id'   => $chat_id,
                    'text'      => $text,
                ];
                return Request::sendMessage($data);
            }
        }

        $data    = [
            'chat_id'       => $chat_id,
            'text'          => 'متاسفانه خطایی در دریافت اطلاعات رخ داده است لطفا دقایقی دیگر دوباره تلاش کنید.',
        ];

        return Request::sendMessage($data);
    }
}
