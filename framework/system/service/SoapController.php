<?php

namespace system\service;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

use system\core\Base;

/**
 * Description of SoapController
 *
 * @author masfu
 */
class SoapController {

    /**
     * urn
     * @var type 
     */
    private $urn;

    /**
     * soap object
     * @var SoapServer 
     */
    private $server;

    /**
     * inherit class
     * @var type 
     */
    private $class;

    /**
     * construct
     * @param type $urn
     */
    public function __construct($urn = 'webservice') {
        Base::import(DIR_APP . '/app/modules/nusoap/nusoap.php');
        $this->urn = $urn;
        $this->class = get_called_class();
    }

    /**
     * index page
     */
    final public function index() {

        if (isset($_REQUEST['wsdl']) or isset($_REQUEST['show'])) {
            $this->generateWsdl();
        } else {
            $this->server = new \SoapServer(null, array('uri' => "urn://$this->urn"));
            $this->server->setObject(new $this);
            $this->server->setPersistence(SOAP_PERSISTENCE_SESSION);
            $this->server->handle();
        }
    }

    /**
     * generate wsdl
     */
    private function generateWsdl() {
        $this->server = new \soap_server();
        $this->server->configureWSDL('WebService', "urn://$this->urn");
        $this->extractMethod();
        $this->server->service(isset($GLOBALS['HTTP_RAW_POST_DATA']) ? $GLOBALS['HTTP_RAW_POST_DATA'] : '');
    }

    /**
     * extract method
     */
    private function extractMethod() {

        $privateMethod = array('index', '__construct');

        foreach (get_class_methods($this->class) as $method) {
            if (in_array($method, $privateMethod)) {
                continue;
            }
            $reflect = new \ReflectionMethod($this->class, $method);
            if ($reflect->isPublic() && !$reflect->isStatic()) {
                $input = $this->extractParameter($reflect);
                $this->server->register($method, $input, array('return' => 'xsd:string'), "uri:$this->urn", false, 'rpc', 'encoded');
            }
        }
    }

    /**
     * extract method
     * @param type $reflect
     * @return string
     */
    private function extractParameter($reflect) {
        $input = array();
        foreach ($reflect->getParameters() as $parameter) {
            $input[$parameter->name] = 'xsd:string';
        }
        return $input;
    }

}
