<?php

namespace Concise\Module;

class UrlModule extends AbstractModule
{
    public function getName()
    {
        return "URLs";
    }

    /**
     * Validate URL.
     *
     * @return bool
     * @syntax url ?:string is valid
     */
    public function urlIsValid()
    {
        $this->failIf(
            filter_var($this->data[0], FILTER_VALIDATE_URL) === false
        );
    }

    /**
     * URL has scheme.
     *
     * @return bool
     * @syntax url ?:string has scheme ?:string
     */
    public function urlHasScheme()
    {
        $this->failIf(!$this->urlHasPart(PHP_URL_SCHEME));
    }

    /**
     * URL has host.
     *
     * @return bool
     * @syntax url ?:string has host ?:string
     */
    public function urlHasHost()
    {
        $this->failIf(!$this->urlHasPart(PHP_URL_HOST));
    }

    /**
     * URL has port.
     *
     * @return bool
     * @syntax url ?:string has port ?:integer
     */
    public function urlHasPort()
    {
        $this->failIf(!$this->urlHasPart(PHP_URL_PORT));
    }

    /**
     * URL has user.
     *
     * @return bool
     * @syntax url ?:string has user ?:string
     */
    public function urlHasUser()
    {
        $this->failIf(!$this->urlHasPart(PHP_URL_USER));
    }

    /**
     * URL has password.
     *
     * @return bool
     * @syntax url ?:string has password ?:string
     */
    public function urlHasPass()
    {
        $this->failIf(!$this->urlHasPart(PHP_URL_PASS));
    }

    /**
     * URL has path.
     *
     * @return bool
     * @syntax url ?:string has path ?:string
     */
    public function urlHasPath()
    {
        $this->failIf(!$this->urlHasPart(PHP_URL_PATH));
    }

    /**
     * URL has query.
     *
     * @return bool
     * @syntax url ?:string has query ?:string
     */
    public function urlHasQuery()
    {
        $this->failIf(!$this->urlHasPart(PHP_URL_QUERY));
    }

    /**
     * URL has fragment.
     *
     * @return bool
     * @syntax url ?:string has fragment ?:string
     */
    public function urlHasFragment()
    {
        $this->failIf(!$this->urlHasPart(PHP_URL_FRAGMENT));
    }

    /**
     * @param string $part
     * @return bool
     */
    protected function urlHasPart($part)
    {
        return parse_url($this->data[0], $part) == $this->data[1];
    }
}
