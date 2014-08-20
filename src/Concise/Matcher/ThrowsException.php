<?php

namespace Concise\Matcher;

class ThrowsException extends AbstractMatcher
{
    public function supportedSyntaxes()
    {
        return array(
            '?:callable throws exception' => 'Assert an exception was thrown.',
        );
    }

    public function match($syntax, array $data = array())
    {
        try {
            $data[0]();
        } catch (\Exception $exception) {
            return true;
        }
        throw new DidNotMatchException("Expected exception to be thrown.");
    }

    public function getTags()
    {
        return array(Tag::EXCEPTIONS);
    }
}
