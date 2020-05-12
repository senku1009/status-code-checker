<?php
class stream
{
    private $context;
    private $auth = '';

    /**
     * stream constructor.
     */
    function __construct()
    {}

    public function isAuthParam($value)
    {
        if (empty($value)) return;
        $this->setAuthString($value);
    }

    private function setAuthString($value)
    {
        $this->auth = base64_encode($value);
    }

    public function getStatus($url)
    {
        try {
            $result = @get_headers($url, '1');

            if (!$result) {
                throw new Exception('URL open failed.');
            }
        } catch (Exception $e) {
            return array('HTTP/1.0 000 URL open failed');
        }

        return $result;
    }

    public function is_url($url = null)
    {
        if (preg_match('/^(https?|ftp)(:\/\/[-_.!~*\'()a-zA-Z0-9;\/?:\@&=+\$,%#]+)$/', $url)) {
            return true;
        } else {
            return false;
        }
    }

    public function makeStreamOption()
    {
        $stream_option = array(
            'method' => 'GET',
            'max_redirects' => 10,
            'ignore_errors' => true,
            'timeout' => 3.0,
            'user_agent' => 'StatusCodeChecker/1.01(https://senku.jp)'
        );

        if ($this->auth != "") {
            $header = array(
                'header' => array(
                    "Authorization: Basic " . $this->auth
                )
            );
            $stream_option = array_merge($stream_option, $header);
        }

        $this->context = stream_context_set_default(['http' => $stream_option]);
    }

}