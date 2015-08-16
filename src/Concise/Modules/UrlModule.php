<?php

namespace Concise\Modules;

use Concise\Matcher\AbstractMatcher;

class UrlModule extends AbstractMatcher
{
    /**
     * Validate URL.
     *
     * @return bool
     * @syntax url ?:string is valid
     */
    public function urlIsValid()
    {
        return filter_var($this->data[0], FILTER_VALIDATE_URL) !== false;
    }

    /**
     * URL has scheme.
     *
     * @return bool
     * @syntax url ?:string has scheme ?:string
     */
    public function urlHasScheme()
    {
        return $this->urlHasPart(PHP_URL_SCHEME);
    }

    /**
     * URL has host.
     *
     * @return bool
     * @syntax url ?:string has host ?:string
     */
    public function urlHasHost()
    {
        return $this->urlHasPart(PHP_URL_HOST);
    }

    /**
     * URL has port.
     *
     * @return bool
     * @syntax url ?:string has port ?:integer
     */
    public function urlHasPort()
    {
        return $this->urlHasPart(PHP_URL_PORT);
    }

    /**
     * URL has user.
     *
     * @return bool
     * @syntax url ?:string has user ?:string
     */
    public function urlHasUser()
    {
        return $this->urlHasPart(PHP_URL_USER);
    }

    /**
     * URL has password.
     *
     * @return bool
     * @syntax url ?:string has password ?:string
     */
    public function urlHasPass()
    {
        return $this->urlHasPart(PHP_URL_PASS);
    }

    /**
     * URL has path.
     *
     * @return bool
     * @syntax url ?:string has path ?:string
     */
    public function urlHasPath()
    {
        return $this->urlHasPart(PHP_URL_PATH);
    }

    /**
     * URL has query.
     *
     * @return bool
     * @syntax url ?:string has query ?:string
     */
    public function urlHasQuery()
    {
        return $this->urlHasPart(PHP_URL_QUERY);
    }

    /**
     * URL has fragment.
     *
     * @return bool
     * @syntax url ?:string has fragment ?:string
     */
    public function urlHasFragment()
    {
        return $this->urlHasPart(PHP_URL_FRAGMENT);
    }

    /**
     * @return bool
     */
    protected function urlHasPart($part)
    {
        return parse_url($this->data[0], $part) == $this->data[1];
    }
}
