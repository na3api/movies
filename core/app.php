<?php
use Core\Exceptions\MyException as MyException;
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of core
 *
 * @author Nazar
 */
class App {
    static $instance;  
    private function __construct() {}
    private function __clone() {}
    private function __sleep() {}
    
    public function start(){
        $method = 'index';
        $params = [];
        foreach (explode('/', substr($_SERVER['REQUEST_URI'], 1)) as $key => $url) {
            switch ($key) {
                case 0:
                    $controller = $this->createClass(ucfirst($url) . 'Controller'); 
                    break;
                
                case 1:
                    $method = $url ;
                    break;
                
                default:
                    $params[$key] = $url;
                    if(isset($params_line))
                        $params_line .= ','.$url;
                    else
                        $params_line = $url;
                            
                    break;
            }           
        }
        eval("\$controller->".$method."(".(isset($params_line)? $params_line:'').");");
    }
    /**
    *   Creates the class to be instantiated, with parameters, and adds it to the
    *   singleton's instances array.
    *   Parameters must be passed as an associative array whose key is the name used
    *   for the passed variable inside the class's constuctor method.
    *   @access private
    *   @param  string  Name of the class
    *   @param  array   Parameters to be passed to the constructor method of the class
    *   @return void
    */
    private function createClass($classname, $params = []) {
        try{
            eval("\$controller = new App\\Controllers\\$classname();");           
        } catch (MyException $ex) {
            throw new MyException($ex->getMessage());
        }
        return $controller;
    }
    /**
    *   Returns an instance of the named class.
    *   @return object  Instance of class
    */
    public static function getInstance(){
        if(!self::$instance){
            self::$instance = new App();
        }
        return self::$instance;
    }
}
