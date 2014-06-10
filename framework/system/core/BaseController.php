<?php

namespace system\core;

/**
 * Description of BaseController
 * @package name
 * @author masfu
 * @copyright (c) 2014, Masfu Hisyam
 */
class BaseController extends BaseView {

    /**
     * layout location
     * @var string 
     */
    protected $layout = "layout\main.php";
    
    /**
     * buffer data
     * @var string 
     */
    private $buffer;
    
    /**
     * is caching
     * @var boolean 
     */
    private $isCache;
    
    /**
     * cache name
     * @var string 
     */
    private $cacheName;

    
    /**
     * public constructor
     */
    public function __construct() {
        ob_start();
        $this->checkAccess();
        $this->isCache = false;
    }

    /**
     * set data
     * @param string $name
     * @param string $value
     */
    public function __set($name, $value) {
        parent::__set($name, $value);
    }

    /**
     * get data
     * @param string $name
     * @return object 
     */
    public function __get($name) {
        if (parent::__get($name)) {
            return parent::__get($name);
        } else if (Base::instance()->$name) {
            return Base::instance()->$name;
        } else
            throw new MainException("$name doesnt exist");
    }

    /**
     * 
     * @param string $name
     * @param string $arguments
     */
    public function __call($name, $arguments) {
// echo $name . ' dsds ' . $arguments;
    }

    /**
     * start cache
     */
    public function startCache() {
        $this->isCache = true;
        $this->cacheName = Base::instance()->router->getController() . '_' . Base::instance()->router->getMethod();
        if (($output = Base::instance()->cache->get($this->cacheName))) {
            echo $output;
            exit();
        }
    }

    /**
     * get the output buffer
     * @return string
     */
    public function getOutputBuffer() {
        return ob_get_clean();
    }

    /**
     * destructor
     */
    public function __destruct() {
        $this->buffer = $this->getOutputBuffer();
        $this->buffer = str_replace("</title>", "</title>" . $this->appendStyle(), $this->buffer);
        $this->buffer = str_replace("</body>", $this->appendScript() . "</body>", $this->buffer);

        if ($this->isCache) {
            Base::instance()->cache->set($this->cacheName, $this->buffer);
        }
        echo $this->buffer;
    }

    /**
     * append script
     * @return string
     */
    private function appendScript() {
        $scriptFile = array_unique(self::$scriptFile);
        $script = array_unique(self::$script);
        $scr = '';
        if (count($scriptFile) > 0) {
            foreach ($scriptFile as $val) {
                $scr.=$val . "\n";
            }
        }

        if (count($script) > 0) {
            $scr .= "<script type=\"text/javascript\">\n/*<![CDATA[*/\njQuery(function(){";
            foreach ($script as $val) {
                $scr.=$val . "\n";
            }
            $scr.="\n});\n/*]]>*/\n</script>";
        }
        return $scr;
    }

    /**
     * append style
     * @return string
     */
    private function appendStyle() {
        $styleFile = array_unique(self::$styleFile);
        $style = array_unique(self::$style);
        $scr = '';
        if (count($styleFile) > 0) {
            foreach ($styleFile as $val) {
                $scr.=$val . "\n";
            }
        }

        if (count($style) > 0) {
            $scr .= "\t<style type='text/css'>";
            foreach ($style as $val) {
                $scr.= "\n\t" . $val;
            }
            $scr.="\n\t</style>\n";
        }
        return $scr;
    }

    /**
     * check access
     * @return boolean
     */
    public function checkAccess() {
        $method = Base::instance()->router->getMethod();
        $auth = null;
        if (method_exists($this, 'access')) {
            $auth = Base::instance()->auth;
            $access = $this->access();
            foreach ($access as $rule) {
                $executes = $rule['executes'];

                $userRole = isset($rule['user']) ? $rule['user'] : $rule['role'];

                $userAuth = isset($rule['user']) ? $auth->getUser() : $auth->getRole();

                if (in_array($method, $executes)) {
                    $accessType = reset($rule);
                    $hasAuth = in_array($userAuth, $userRole);
                    if ($accessType == 'grant' and $hasAuth) {
                        return true;
                    } else if ($accessType == 'revoke' and $hasAuth) {
                        throw new HttpException('you are not allowed to access this page', 403);
                    }
                }
            }
        }
    }

    /**
     * redirect
     * @param string $url
     */
    public function redirect($url) {
        if ($url and strpos($url, "://") == false)
            $url = Base::instance()->base_url . $url;
        header("Location: " . $url);
    }

    /**
     * 
     */
    public function beforeExecute() {
        
    }

    /**
     * 
     */
    public function afterExecute() {
        
    }

}
