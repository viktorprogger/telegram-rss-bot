<?php
declare(strict_types=1);

namespace rssBot\commands;

use rssBot\services\parsers\DefaultParser;
use Yii;
use yii\console\Controller;

class ParseController extends Controller
{
    public function actionIndex()
    {
        foreach (Yii::$app->params['rss_channels'] as $channelConfig) {
            foreach ($channelConfig['links'] as $title => $link) {
                /** @var DefaultParser $parser */
                /** @noinspection PhpUnhandledExceptionInspection */
                $parser = Yii::createObject(DefaultParser::class, ['title' => $title, 'url' => $link]);
                $elements = $parser->parse();
            }
        }
    }
}
