<?php
/**
 * Created by PhpStorm.
 * User: santino83
 * Date: 28/05/19
 * Time: 1.18
 */

namespace Costaplus;


use Symfony\Component\Yaml\Yaml;

class FatConfiguration2
{
    const YAML = 'yml';
    const PHP = 'php';
    const JSON = 'json';

    private $filename;

    private $type;

    // per brevità, salvo la configurazione in un array invece di usare
    // singole proprietà private e poi definire i getters
    private $config = [];

    /**
     * FatConfiguration constructor.
     * @param $filename
     * @param string $type
     */
    public function __construct($filename = null, $type = self::YAML)
    {
        $this->filename = $filename;
        $this->type = $type;
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

        switch ($this->type)
        {
            case self::YAML:
                $this->loadFromYaml();
                break;
            case self::PHP:
                $this->loadFromPHP();
                break;
            case self::JSON:
                $this->loadFromJson();
                break;
            default:
                throw new \RuntimeException('Invalid type '.$this->type);
        }

    }

    private function loadFromJson()
    {
        try{
            $this->config = json_decode(file_get_contents($this->filename), JSON_OBJECT_AS_ARRAY);
        }catch (\Exception $ex){
            throw new \RuntimeException('Unable to parse config file: '.$ex->getMessage());
        }
    }

    private function loadFromYaml()
    {
        try {
            $this->config = Yaml::parseFile($this->filename);
        }catch (\Exception $ex){
            throw new \RuntimeException('Unable to parse config file: '.$ex->getMessage());
        }
    }

    private function loadFromPHP()
    {
        try{
            $this->config = require $this->filename;
        }catch (\Exception $ex){
            throw new \RuntimeException('Unable to load config file: '.$ex->getMessage());
        }
    }
}