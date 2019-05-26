<?php
/**
 * Created by PhpStorm.
 * User: santino83
 * Date: 26/05/19
 * Time: 19.09
 */

namespace Costaplus\Inheritance;


class Car extends Automobile
{

    public function playSound()
    {
        return 'beep';
    }

    /**
     * @return string
     */
    function getType()
    {
        return 'CAR';
    }

}