<?php

namespace core\lib;

class class_config{

    static $Title  = 'base progetti';
    static $Debug  = false;

    /**
     * Setting database
     */
    static $db_server='localhost';
    static $db_name  ='test';
    static $db_user  ='root';
    static $db_pass  ='';


    /**
     * Setting Ldap
     */
    static $ldap_server='0.0.0.0';
    static $ldap_port  =0;
}
?>