<?php
/**
 * Created by PhpStorm.
 * User: santino83
 * Date: 26/05/19
 * Time: 19.07
 */

namespace Costaplus\Inheritance;


abstract class Automobile
{

    /**
     * @var Engine
     */
    private $engine;

    /**
     * Automobile constructor.
     * @param Engine $engine
     */
    public function __construct(Engine $engine = null)
    {
        $this->engine = $engine;
    }

    /**
     * @param Engine $engine
     */
    public function setEngine($engine)
    {
        $this->engine = $engine;
    }

    /**
     * @return string
     */
    abstract function playSound();

    /**
     * @return string
     */
    public function start()
    {
        if(!$this->engine)
        {
            throw new \RuntimeException("Engine not found");
        }

        $this->engine->on();
        return $this->getType()." started";
    }

    /**
     * @return string
     */
    public function stop()
    {
        $this->engine->off();
        return $this->getType()." stopped";
    }

    /**
     * @return bool
     */
    public function isStarted()
    {
        return $this->engine->isStarted();
    }

    /**
     * @return string
     */
    function getType()
    {
        return 'GENERIC';
    }

}