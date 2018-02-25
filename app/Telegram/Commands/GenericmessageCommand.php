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
use Longman\TelegramBot\Conversation;
use Longman\TelegramBot\Entities\Keyboard;
use Longman\TelegramBot\Request;
/**
 * Generic message command
 *
 * Gets executed when any type of message is sent.
 */
class GenericmessageCommand extends SystemCommand
{
    /**
     * @var string
     */
    protected $name = 'genericmessage';
    /**
     * @var string
     */
    protected $description = 'Handle generic message';
    /**
     * @var string
     */
    protected $version = '1.1.0';
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
        //If a conversation is busy, execute the conversation command after handling the message
        $conversation = new Conversation(
            $this->getMessage()->getFrom()->getId(),
            $this->getMessage()->getChat()->getId()
        );
        //Fetch conversation command if it exists and execute it
        /*if ($conversation->exists() && ($command = $conversation->getCommand())) {
            return $this->telegram->executeCommand($command);
        }*/

        $message = $this->getMessage();
        $chat_id = $message->getChat()->getId();

        if ($message->getContact()) {
            $contact = $message->getContact();
            /*$customer = Customer::firstOrCreate(['account_id' => $message->getFrom()->getId(), 'phone_number' => $contact->getPhoneNumber(), 'first_name' => $contact->getFirstName(), 'last_name' => $contact->getLastName(), 'username' => $message->getChat()->getUsername(), 'chat_id' => $chat_id]);
            $customer->update(['is_active' => 1]);*/
		Customer::updateOrCreate(
		    [
			'account_id' => $message->getFrom()->getId(),
		    ],
		    [
			'phone_number' => $contact->getPhoneNumber(), 'first_name' => $contact->getFirstName(), 'last_name' => $contact->getLastName(), 'username' => $message->getChat()->getUsername(), 'chat_id' => $chat_id, 'is_active' => 1
		    ]
		);
            $text = sprintf("سپاس %s عزیز\nشما با موفقیت ثبت نام شدید.\n برای استفاده از امکانات ابتدا از طریق منو علاقه مندی های خود را انتخاب کنید:".PHP_EOL."/keyboard", $contact->getFirstName());
            $keyboard = new Keyboard(
                [ "\xE2\x9D\xA4 مدیریت علاقه‌مندی‌ها", "\xE2\x9E\xA1 مشاهده مطالب مجله"],
            	["\xF0\x9F\x9A\xAB لغو اشتراک", "\xF0\x9F\x92\xB0 امتیاز من"]
            );
	    $keyboard->setResizeKeyboard(true);

            $data = [
                'chat_id' => $chat_id,
                'text'    => $text,
                'reply_markup' => $keyboard,
            ];

            return Request::sendMessage($data);
        }

        $commands = ['register' => 'ثبت نام', 'revoke' => "\xF0\x9F\x9A\xAB لغو اشتراک", 'nextcontent' => "\xE2\x9E\xA1 مشاهده مطالب مجله", 'favoritecategories' => "\xE2\x9D\xA4 مدیریت علاقه‌مندی‌ها", 'score' => "\xF0\x9F\x92\xB0 امتیاز من",];
        $command = 'keyboard';

        if ($entered_key = array_search($message->getText(), $commands)) {
            $command = $entered_key;
        }

        return $this->getTelegram()->executeCommand($command);

        /*$answers = [
            'سلام' => 'درود بر تو',
            'خوبی؟' => 'خوبم مرسی تو چطوری؟',
            'چطوری؟' => 'خوبم مرسی تو چطوری؟',
            'منم خوبم مرسی' => 'خدا رو شکر',
            'خوبم' => 'خدا رو شکر',
            'خوبم مرسی' => 'خدا رو شکر',
            'منم خوبم' => 'خدا رو شکر',
            'مرسی' => 'قربانت',
            'چه خبر؟' => 'سلامتی! شما چه خبر؟',
            'سلامتی' => 'خب خدا رو شکر',
            'منم سلامتی' => 'خب خدا رو شکر',
            'ما هم سلامتی' => 'خب خدا رو شکر',
            'نیستی' => 'هستیم در خدمت شما قربان :)',
            'نیستی!' => 'هستیم در خدمت شما قربان :)',
            'جوون' => 'جوووووووون :)',
        ];

        if (array_key_exists($message->getText(), $answers)) {
            $text = $answers[$message->getText()];
        }*/
    }
}
