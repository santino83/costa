<?php
/**
 * Created by PhpStorm.
 * User: santino83
 * Date: 26/05/19
 * Time: 19.25
 */

namespace Costaplus\Inheritance;


class Engine
{

    /**
     * @var string
     */
    private $cc;

    /**
     * @var string
     */
    private $power;

    /**
     * @var bool
     */
    private $started = false;

    /**
     * Engine constructor.
     * @param string $cc
     * @param string $power
     */
    public function __construct($cc, $power)
    {
        $this->cc = $cc;
        $this->power = $power;
    }

    /**
     * @return bool
     */
    public function isStarted()
    {
        return $this->started;
    }

    /**
     * Turn engine on
     */
    public function on()
    {
        $this->started = true;
    }

    /**
     * Turn Engine off
     */
    public function off()
    {
        $this->started = false;
    }

    /**
     * @return string
     */
    public function getCc()
    {
        return $this->cc;
    }

    /**
     * @return string
     */
    public function getPower()
    {
        return $this->power;
    }

}