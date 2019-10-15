<?php
declare(strict_types=1);

namespace rssBot\commands;

use rssBot\ar\Feed;
use rssBot\dto\FeedItemInterface;
use rssBot\services\parsers\DefaultParser;
use rssBot\services\senders\SenderInterface;
use Yii;
use yii\console\Controller;

class ParseController extends Controller
{
    /**
     * @var SenderInterface
     */
    private $sender;

    public function __construct($id, $module, SenderInterface $sender, $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->sender = $sender;
    }

    public function actionIndex()
    {
        foreach (Yii::$app->params['rss_channels'] as $channelConfig) {
            foreach ($channelConfig['links'] as $linkConfig) {
                /** @var DefaultParser $parser */
                /** @noinspection PhpUnhandledExceptionInspection */
                $parser = Yii::createObject(DefaultParser::class);
                foreach ($linkConfig as $key => $value) {
                    $parser->$key = $value;
                }

                /** @var FeedItemInterface $element */
                foreach ($parser->parse() as $element) {
                    if (!Feed::findOne(['hash' => $element->getHash()])) {
                        $ar = new Feed();
                        $ar->hash = $element->getHash();
                        $ar->save();

                        $this->sender->send($element, $channelConfig['chat_id']);
                    }
                }
            }
        }
    }
}
