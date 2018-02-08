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

use App\ContentCategory;
use App\CustomerCategory;
use Longman\TelegramBot\Commands\SystemCommand;
use Longman\TelegramBot\Entities\InlineKeyboard;
use Longman\TelegramBot\Entities\InlineKeyboardButton;
use Longman\TelegramBot\Request;

/**
 * Start command
 */
class FavoriteCategoriesCommand extends SystemCommand
{
    /**
     * @var string
     */
    protected $name = 'favorite categories';

    /**
     * @var string
     */
    protected $description = 'Select favorite categories';

    /**
     * @var string
     */
    protected $usage = '/favoritecategories';

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
        $text           = 'دسته‎‌بندی‌های مورد علاقه خود را مدیریت کنید:';

        /*$text = "اشتراک شما لغو شد و زین پس دیگر مطلبی دریافت نخواهید کرد.\n برای اشتراک مجدد دستور /register را وارد کنید.";

        $customer = Customer::where('account_id', $message->getFrom()->getId())->where('is_active', 1)->get()->first();
        if (is_null($customer)) {
            $text = "اشتراکی با این حساب کاربری یافت نشد!\n برای اطلاعات بیشتر دستور /support را وارد کنید.";
        } else {
            $customer->update(['is_active' => 0]);
        }*/

        $categories = ContentCategory::where('is_active', 1)->get();

        $customer_categories = CustomerCategory::where('customer_id', $customer_id)->get(['category_id'])->implode('category_id', ',');
        $customer_categories = explode(',', $customer_categories);

        $inline_keyboard_categories = [];
        foreach ($categories as $category) {
            array_push($inline_keyboard_categories, new InlineKeyboardButton(['text' => ((in_array($category['id'], $customer_categories)) ? '✅ ' : ' ') . $category['name'], 'callback_data' => 'category_'.$category['id']]));
        }

        $inline_keyboard = new InlineKeyboard($inline_keyboard_categories);
        $inline_keyboard->setResizeKeyboard(true);

        $data = [
            'chat_id'      => $chat_id,
            'text'         => $text,
            'reply_markup' => $inline_keyboard,
        ];
        return Request::sendMessage($data);
    }
}
