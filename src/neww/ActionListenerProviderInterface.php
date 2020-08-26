<?php

declare(strict_types=1);

namespace rssBot\neww;

use rssBot\action\ActionInterface;

interface ActionListenerProviderInterface
{
    /**
     * @param ActionInterface $action An executed action for which to return the relevant listeners
     *
     * @return ListenerInterface[]
     */
    public function getListenersForAction(ActionInterface $action): iterable;
}
