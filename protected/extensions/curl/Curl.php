<?php

/*

* Yii extension CURL

* This is a base class for procesing CURL REQUEST
*
* @author Igor Ivanović
* @version 0.2
* @last update:
* @filesource CURL.php
*
1. You have to download and upload files to /protected/extensions/curl/.
2. Include extension in config/main.php


you can setup timeout, http_login, proxy, proxylogin, cookie, and any curl option

'curl' => array(
    'class' => 'application.extensions.curl.Curl',
    'options'=>array(
        'timeout'=>0,

        'cookie'=>array(
            'set'=>'cookie'
        ),

        'login'=>array(
            'username'=>'myuser',
            'password'=>'mypass'
        ),

        'proxy'=>array(
            'url'=>'someproxy.com',
            'port'=>80
        ),

        'proxylogin'=>array(
            'username'=>'someuser',
            'password'=>'somepasswords'
        ),


        'setOptions'=>array(
             CURLOPT_UPLOAD => true,
             CURLOPT_USERAGENT => Yii::app()->params['agent'];
        ),
    )
),
*/

class Curl extends CApplicationComponent
{

    /**
     * Url to connect
     * @var string
     */
    protected $url;
    /**
     * Connection
     * @var object
     */
    protected $ch;

    /**
     * Options
     * @var array
     */
    public $options = array();
    /**
     * Info
     * @var array
     */
    private $info = array();
    /**
     * Error code
     * @var int
     */
    private $error_code = 0;
    /**
     * Error
     * @var string
     */
    private $error = null;

    /**
     * Gets data
     * @var null
     */
    private $data = null;

    /**
     * Valid options
     * @var array
     */
    protected $validOptions = array(
        'timeout'    => array('type' => 'integer'),
        'login'      => array('type' => 'array'),
        'proxy'      => array('type' => 'array'),
        'proxylogin' => array('type' => 'array'),
        'setOptions' => array('type' => 'array'),
    );


    /**
     * Initialize the extension
     * check to see if CURL is enabled and the format used is a valid one
     */
    public function init()
    {
        if (!function_exists('curl_init')) {
            throw new CException(Yii::t('Curl', 'You must have CURL enabled in order to use this extension.'));
        }

    }

    /**
     * Set any extra option
     * @param $key
     * @param $value
     */
    protected function setOption($key, $value)
    {
        curl_setopt($this->ch, $key, $value);
    }


    /**
     * Format url
     * @param $url
     */
    public function setUrl($url)
    {
        if (!preg_match('!^\w+://! i', $url)) {
            $url = 'http://' . $url;
        }
        $this->url = $url;
    }


    /**
     * Set cookies
     * @param $values
     * @throws CException
     */
    public function setCookies($values)
    {
        if (!is_array($values)) {
            throw new CException(Yii::t('Curl', 'options must be an array'));
        } else {
            $params = $this->cleanPost($values);
        }
        $this->setOption(CURLOPT_COOKIE, $params);
    }

    /**
     * Setup http login
     * @param string $username
     * @param string $password
     */
    public function setHttpLogin($username = '', $password = '')
    {
        $this->setOption(CURLOPT_USERPWD, $username . ':' . $password);
    }

    /**
     * Set proxy
     * @param $url
     * @param int $port
     */
    public function setProxy($url, $port = 80)
    {
        $this->setOption(CURLOPT_HTTPPROXYTUNNEL, true);
        $this->setOption(CURLOPT_PROXY, $url . ':' . $port);
    }

    /**
     * Set proxy login
     * @param string $username
     * @param string $password
     */
    public function setProxyLogin($username = '', $password = '')
    {
        $this->setOption(CURLOPT_PROXYUSERPWD, $username . ':' . $password);
    }

    /**
     * Check options
     * @param $value
     * @param $validOptions
     * @throws CException
     */
    protected static function checkOptions($value, $validOptions)
    {
        if (!empty($validOptions)) {
            foreach ($value as $key => $val) {

                if (!array_key_exists($key, $validOptions)) {
                    throw new CException(Yii::t('Curl', '{k} is not a valid option', array('{k}' => $key)));
                }
                $type = gettype($val);
                if ((!is_array($validOptions[$key]['type']) && ($type != $validOptions[$key]['type'])) || (is_array(
                    $validOptions[$key]['type']
                ) && !in_array($type, $validOptions[$key]['type']))
                ) {
                    throw new CException(Yii::t(
                        'Curl',
                        '{k} must be of type {t}',
                        array('{k}' => $key, '{t}' => $validOptions[$key]['type'])
                    ));
                }

                if (($type == 'array') && array_key_exists('elements', $validOptions[$key])) {
                    self::checkOptions($val, $validOptions[$key]['elements']);
                }
            }
        }
    }

    /**
     * Defaults for using
     */
    protected function defaults()
    {
        !isset($this->options['timeout']) ? $this->setOption(CURLOPT_TIMEOUT, 30) : $this->setOption(
            CURLOPT_TIMEOUT,
            $this->options['timeout']
        );
        isset($this->options['setOptions'][CURLOPT_HEADER]) ? $this->setOption(
            CURLOPT_HEADER,
            $this->options['setOptions'][CURLOPT_HEADER]
        ) : $this->setOption(CURLOPT_HEADER, true);
        isset($this->options['setOptions'][CURLOPT_RETURNTRANSFER]) ? $this->setOption(
            CURLOPT_RETURNTRANSFER,
            $this->options['setOptions'][CURLOPT_RETURNTRANSFER]
        ) : $this->setOption(CURLOPT_RETURNTRANSFER, true);
        isset($this->options['setOptions'][CURLOPT_FOLLOWLOCATION]) ? $this->setOption(
            CURLOPT_FOLLOWLOCATION,
            $this->options['setOptions'][CURLOPT_FOLLOWLOCATION]
        ) : $this->setOption(CURLOPT_FOLLOWLOCATION, true);
        isset($this->options['setOptions'][CURLOPT_FAILONERROR]) ? $this->setOption(
            CURLOPT_FAILONERROR,
            $this->options['setOptions'][CURLOPT_FAILONERROR]
        ) : $this->setOption(CURLOPT_FAILONERROR, true);
    }


    /**
     * Has error
     * @return stdClass
     */
    public function hasErrors()
    {
        return $this->error_code !== 0;
    }


    /**
     * Errors
     * @return stdClass
     */
    public function getErrors()
    {
        $c           = new stdClass();
        $c->code     = $this->error_code;
        $c->message  = $this->error;
        $c->hasError = $this->error_code !== 0;
        return $c;
    }

    /**
     * Return data
     * @return null
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * Return data
     * @return null
     */
    public function getInfo()
    {
        return $this->info;
    }


    /**
     * Handle curl
     * @param $url
     * @param array $post_data
     * @return $this
     * @throws CException
     */
    private function handleCurl($url, $post_data = array())
    {

        $this->setUrl($url);

        if (!$this->url) {
            throw new CException(Yii::t('Curl', 'You must set Url.'));
        }

        $this->ch = curl_init();

        self::checkOptions($this->options, $this->validOptions);


        if (empty($post_data)) {
            $this->setOption(CURLOPT_URL, $this->url);
            $this->defaults();
        } else {
            if (!is_array($post_data)) {
                throw new CException('post_data must be an array type');
            }
            $this->setOption(CURLOPT_URL, $this->url);
            $this->defaults();
            $this->setOption(CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
            $this->setOption(CURLOPT_POST, 1);
            $this->setOption(CURLOPT_POSTFIELDS, $post_data);
        }

        if (isset($this->options['setOptions'])) {
            foreach ($this->options['setOptions'] as $k => $v) {
                $this->setOption($k, $v);
            }
        }

        isset($this->options['login']) ? $this->setHttpLogin(
            $this->options['login']['username'],
            $this->options['login']['password']
        ) : null;
        isset($this->options['proxy']) ? $this->setProxy(
            $this->options['proxy']['url'],
            $this->options['proxy']['port']
        ) : null;

        if (isset($this->options['proxylogin'])) {
            if (!isset($this->options['proxy'])) {
                throw new CException(Yii::t(
                    'Curl',
                    'If you use "proxylogin", you must define "proxy" with arrays.'
                ));
            } else {
                $this->setProxyLogin($this->options['login']['username'], $this->options['login']['password']);
            }
        }

        $this->data = curl_exec($this->ch);

        // Request failed
        if ($this->data === false || $this->data === null) {
            $this->error_code = curl_errno($this->ch);
            $this->error      = curl_error($this->ch);
        } else {
            $this->info = curl_getinfo($this->ch);

        }

        curl_close($this->ch);


        return $this;
    }

    /**
     * Runing curl
     * @param $url
     * @param bool $GET
     * @param array $POSTSTRING
     * @return mixed
     * @throws CException
     */
    public function run($url, $post_data = array())
    {
        $reflection = new ReflectionMethod(get_class($this), 'handleCurl');
        $reflection->setAccessible(true);
        return $reflection->invokeArgs($this, array($url, $post_data));
    }



}//end of method