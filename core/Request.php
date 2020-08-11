<?php namespace Core;

class Request
{
    private $storage;

    public function __construct()
    {
        if (empty($_REQUEST)) {
            $data = json_decode(file_get_contents('php://input'), true);
        } else {
            $data = $_REQUEST;
        }
        $this->storage = $this->clean($data);
    }

    public function __get($name)
    {
        return $this->get($name);
    }

    public function get($name)
    {
        if (isset($this->storage[$name])) return $this->storage[$name];
        return null;
    }

    private function clean($data)
    {
        if (is_array($data)) {
            $cleaned = [];
            foreach ($data as $key => $value) {
                $cleaned[$key] = $this->clean($value);
            }
            return $cleaned;
        }
        return trim(htmlspecialchars($data, ENT_QUOTES));
    }
}
