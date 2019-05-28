<?php
/**
 * Created by PhpStorm.
 * User: santino83
 * Date: 28/05/19
 * Time: 1.46
 */

$loader = require_once __DIR__.'/vendor/autoload.php';

/*
 * load configuration, by default: ./config/app_config.ym
 *
 * NOTA: per brevita vengono omessi check e throws di exceptions
 */
$configDirs = [__DIR__.'/config'];
$fileLocator = new \Symfony\Component\Config\FileLocator($configDirs);

// locate file
$configFile = $fileLocator->locate('app_config.yml',null, true);

// load config
$configContent = \Symfony\Component\Yaml\Yaml::parseFile($configFile);

// validate config
$processor = new \Symfony\Component\Config\Definition\Processor();
$configurationTree = new \Costaplus\Config\Configuration();

$processedConfig = $processor->processConfiguration($configurationTree,[$configContent]);

// load Config Object
$config = new \Costaplus\Config\Config($processedConfig);

// app ready to started
echo $config->getAppName()."\n";
