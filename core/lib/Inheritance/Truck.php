<?php
/**
 * Created by PhpStorm.
 * User: santino83
 * Date: 26/05/19
 * Time: 19.13
 */

namespace Costaplus\Inheritance;


class Truck extends Automobile
{
    public function playSound()
    {
        return "boooow";
    }

    function getType()
    {
        return 'TRUCK';
    }


}