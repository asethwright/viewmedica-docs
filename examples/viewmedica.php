<?php

// An example call...
//
// $vm = Viewmedica::make(array(
//     'username' => 'yourusername',
//     'password' => 'yourpassword',
//     'practice' => 'Your Practice Name',
//     'url' => 'yoururl.com',
//     'content' => 'A_b6cd20aa,A_f6094215,A_0c8762d6'
// ));
//
// $client = $vm->response['body']; //json

class Viewmedica {

    const VERSION = 1.0;
    const REQUEST_URL = 'https://swarminteractive.com/vm/api/client?key=';
    const API_KEY = 'f30d2edac81a7bfd05fa2c01851a87244c926102';

    private $fields = array(
        // 'username' => "",
        // 'password' => "",
        // 'practice' => "",
        // 'url' => "",
        // 'content' => ""
    );

    private $encoded = "";

    public $response = array();

    public function __construct($params = array(), $call = false)
    {
        if (count($params)) {
            foreach ($params as $key => $param) {
                $this->fields[$key] = urlencode($param);
            }
        }

        if ($call && count($this->fields)) {
            $this->execute();
        }

        return $this;
    }

    public static function make($params, $call = true)
    {
        return new static($params, $call);
    }

    public function execute()
    {
        $this->build();
        $this->curl();
    }

    private function build()
    {
        foreach ($this->fields as $key => $value) {
            $this->encoded .= $key . "=" . $value . "&";
        }

        rtrim($this->encoded, "&");
    }

    private function curl()
    {
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, self::REQUEST_URL . self::API_KEY);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $this->encoded);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HEADER, true);

        $response = curl_exec($ch);
        $header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);

        curl_close($ch);

        $this->response['header'] = substr($response, 0, $header_size);
        $body = substr($response, $header_size);
        $this->response['body'] = json_decode($body);
    }

}

