<?php
/**
 * Created by PhpStorm.
 * User: santino83
 * Date: 28/05/19
 * Time: 1.12
 */

namespace Costaplus;


use Symfony\Component\Yaml\Yaml;

class FatConfiguration
{

    private $filename;

    // per brevità, salvo la configurazione in un array invece di usare
    // singole proprietà private e poi definire i getters
    private $config = [];

    /**
     * FatConfiguration constructor.
     * @param $filename
     */
    public function __construct($filename = null)
    {
        $this->filename = $filename;
        $this->load();
    }

    // esempio di metodi accessori alle proprietà
    // NOTA: le configurazioni sono solitamente READ ONLY, no setters
    public function getAppName()
    {
        return $this->config['app_name'];
    }

    private function load()
    {

        if(!$this->filename)
        {
            // NOTA: defaults (orrible)
            $this->filename = __DIR__.'/../../config/app_config.yml';
        }

        if(!file_exists($this->filename) || !is_readable($this->filename))
        {
            throw new \RuntimeException($this->filename.' does not exist or is not readable');
        }

        $content = file_get_contents($this->filename);

        try {
            $this->config = Yaml::parse($content);
        }catch (\Exception $ex){
            throw new \RuntimeException('Unable to parse config file: '.$ex->getMessage());
        }

    }
}