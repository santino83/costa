<?php
/**
 * Created by PhpStorm.
 * User: santino83
 * Date: 28/05/19
 * Time: 1.23
 */

namespace Costaplus;


class Configuration
{

    // per brevità, salvo la configurazione in un array invece di usare
    // singole proprietà private e poi definire i getters
    private $config = [];

    /**
     * Configuration constructor.
     * @param array $config
     */
    public function __construct(array $config = [])
    {
        $this->config = $config;
    }

    // esempio di metodi accessori alle proprietà
    // NOTA: le configurazioni sono solitamente READ ONLY, no setters
    public function getAppName()
    {
        return $this->config['app_name'];
    }

}