<?php

declare(strict_types=1);

namespace rssBot\models\sender\messages;

use Yiisoft\Validator\MissingAttributeException;

abstract class AbstractMessage implements MessageInterface
{
    public function getAttributeValue(string $attribute)
    {
        if (!$this->hasAttribute($attribute)) {
            throw new MissingAttributeException(sprintf('No property "%s" in %s', $attribute, static::class));
        }

        return $this->$attribute;
    }

    public function hasAttribute(string $attribute): bool
    {
        return property_exists($this, $attribute);
    }
}
