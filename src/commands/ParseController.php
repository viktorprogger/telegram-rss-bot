<?php
declare(strict_types=1);

namespace rssBot\commands;

use rssBot\services\parsers\DefaultParser;
use rssBot\services\senders\SenderInterface;
use Yii;
use yii\console\Controller;

class ParseController extends Controller
{
    /**
     * @var SenderInterface
     */
    private SenderInterface $sender;

    public function __construct($id, $module, SenderInterface $sender, $config = [])
    {
        $this->sender = $sender;
        parent::__construct($id, $module, $config);
    }

    public function actionIndex()
    {
        foreach (Yii::$app->params['rss_channels'] as $channelConfig) {
            foreach ($channelConfig['links'] as $linkConfig) {
                /** @var DefaultParser $parser */
                /** @noinspection PhpUnhandledExceptionInspection */
                $parser = Yii::createObject(DefaultParser::class, $linkConfig);
                foreach ($parser->parse() as $element) {
                    $this->sender->send($element, $channelConfig['chat_id']);
                }
            }
        }
    }
}
