<?php
/**
 * Created by PhpStorm.
 * User: santino83
 * Date: 28/05/19
 * Time: 0.21
 */

require_once __DIR__.'/vendor/autoload.php';

/*
 * andiamo a configurare la nostra applicazione, in maniera statica,
 * usando dei parametri di configurazione salvati su file.
 *
 * per semplicità configureremo:
 *
 * - nome dell'applicazione
 * - versione dell'app
 * - dati di accesso al db
 * - dati di accesso a ldap
 * - dati di accesso imap
 */

/*
 * 1) per salvare i parametri statici di configurazione, potremmo decidere di usare un'array chiave => valore
 *
 * NOTA: in nessun caso usare define e globals varie, è tutta roba obsoleta che riguarda prettamente una programmazione
 * scripting e non OO
 */

$config1 = [
    'app_name' => 'My App',
    'app_version' => '1.0.0',
    'db_name' => 'mydb',
    'db_host' => 'localhost',
    'db_port' => 3306,
    'db_driver' => 'mysql',
    'db_username' => 'myusername',
    'db_passwdd' => 'mypasswd',
    'ldap_host' => 'localhost',
    'ldap_username' => 'myldapusername',
    'ldap_passwd' => 'myldappasswd',
    'imap_host' => 'imap.gmail.com',
    'imap_port' => '993'
];

//print_r($config1);

/*
 * come la uso?
 */

$conn = new \Costaplus\ClassConn();
$conn->setName($config1['db_name'])
    ->setUser($config1['db_username']);
    // etc ...

/*
 * dove lo salvo? filesystem in file PHP facilmente identificabile e modificabile anche da non esperti
 */
$config2 = require_once __DIR__.'/config/app_config.php';
//print_r($config2);

/*
 * 2) allo stesso modo, si può salvare la config su file in formato JSON, INI o (ultimo trend) in YAML
 * es con json:
 */

file_put_contents(__DIR__.'/config/app_config.json', json_encode($config2, JSON_OBJECT_AS_ARRAY | JSON_PRETTY_PRINT));

$config3 = json_decode(file_get_contents(__DIR__.'/config/app_config.json'), JSON_OBJECT_AS_ARRAY);
//print_r($config3);

/*
 * per usare YAML, occorre una libreria esterna: composer require symfony/yaml
 */
file_put_contents(__DIR__.'/config/app_config.yml', \Symfony\Component\Yaml\Yaml::dump($config1));

$config4 = \Symfony\Component\Yaml\Yaml::parseFile(__DIR__.'/config/app_config.yml');
$config4 = \Symfony\Component\Yaml\Yaml::parse(file_get_contents(__DIR__.'/config/app_config.yml'));

//print_r($config4);

/*
 * la struttura di un file di config è a libero gusto, può anche essere nested
 */
$yamlConfig = \Symfony\Component\Yaml\Yaml::dump([
    'app' => [ 'name' => 'My App', 'version' => '1.0.0'],
    'db' => [
        'name' => 'mydb',
        'port' => 3306,
        'foo' => 'bar'
    ],
    'ldap' => ['host' => 'localhost', 'username' => 'myldapusername'],
    'imap' => ['host' => 'imap.gmail.com', 'port' => '993']
]);
file_put_contents(__DIR__.'/config/app_config2.yml', $yamlConfig);

$config5 = \Symfony\Component\Yaml\Yaml::parseFile(__DIR__.'/config/app_config2.yml');
//print_r($config5);

/*
 * I config creati sopra sono tutti ARRAY (volendo potrebbero essere StdObject di PHP). Cmq non sono facilmente utilizzabili all'interno
 * dell'app:
 * - ho un array e non un oggetto (tipico dello scripting!)
 * - ogni volta che voglio accedere ad una proprietà di configurazione, mi devo ricordare il nome della chiave dell'array (o l'alberatura del medesimo),
 *   diventa complicato cambiare nome delle chiavi/proprieta/refactory
 * - non posso validare la configurazione
 */

/*
 * Creo una classe che rappresenti la mia configurazione (per brevità, userò la versione di config1, senza alberatura)
 */

$fatConfiguration = new \Costaplus\FatConfiguration();
//echo $fatConfiguration->getAppName()."\n";

/*
 * FatConfiguration non è flessibile: posso usare solo file YML. Refactory
 */
$fatConfiguration2 = new \Costaplus\FatConfiguration2(__DIR__.'/config/app_config.php', \Costaplus\FatConfiguration2::PHP);
//echo $fatConfiguration2->getAppName()."\n";

/*
 * Entrambe le versioni di FatConfiguration fanno troppe, ovvero gestiscono i getter della configurazione e gestiscono
 * il load da filesystem. Il load da filesystem è una procedura troppo complicata e troppo soggetta a modifiche
 * (cambia l'OS, cambiano le path dei default, cambiano i driver di parsing, etc..), e la nostra configurazione
 * all'interno dell'app dovrebbe cmq restare una POJO semplice usato solo per configurare altri oggetti.
 * soluzione: esternalizzo la lettura da filesystem
 */

$content = \Symfony\Component\Yaml\Yaml::parseFile(__DIR__.'/config/app_config.yml');
$configuration = new \Costaplus\Configuration($content);

//echo $configuration->getAppName()."\n";

/*
 * potrei voler definire la validazione della configurazione, oppure fare il merge da piu file di configurazione,
 * caricare la configurazione in base all'environment in cui mi trovo, etc... Rifaccio da zero? Posso sfruttare cosa è stato
 * fatto da altry: Symfony Config Component (composer require symfony/config)
 */

$configDirectories = [__DIR__.'/config'];

$fileLocator = new \Symfony\Component\Config\FileLocator($configDirectories);
$yamlConfigFile = $fileLocator->locate('app_config.yml',null, true);

//echo $yamlConfigFile."\n";

/*
 * posso parsare il file e caricare la configuration
 */
$content = [];
try{
    $content = \Symfony\Component\Yaml\Yaml::parseFile($yamlConfigFile);
}catch (\Exception $ex){
    throw new RuntimeException("Unable to load configuration from ".$yamlConfigFile.": ".$ex->getMessage());
}

$configuration2 = new \Costaplus\Configuration($content);
//echo $configuration2->getAppName()."\n";

/*
 * il Config Component consente anche di validare la configurazione con valori opzionali, obbligatori, tipi precisi, array, enum
 * etc. Vedere la documentazione in merito
 *
 * NOTA: Config Component alla fine restituisce sempre e solo un array dei parametri di configurazione, se si vuole
 * usare un oggetto con Configuration, bisogna implementare a mano il load di tale oggetto come fatto in precedenza
 * (limitazione di PHP)
 */

/*
 * carico la configurazione da validare
 */
$yamlConfigFile = $fileLocator->locate('app_config_validate.yml',null, true);
$content = \Symfony\Component\Yaml\Yaml::parseFile($yamlConfigFile);

/*
 * valido la configurazione
 */
$processor = new \Symfony\Component\Config\Definition\Processor();
$configurationTree = new \Costaplus\Config\Configuration();
$processedConfig = $processor->processConfiguration($configurationTree, [$content]);

//print_r($processedConfig);

$config6 = new \Costaplus\Config\Config($processedConfig);
echo $config6->getAppName()."\n";
