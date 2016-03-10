<?php
class CDebug {
    static
        $_profiler = array(),
        $_vars = array(),
        $_prefix = "";
    public function __construct() {
    }
	
    public function setPrefix($prefix) {
        self::$_prefix = $prefix;
    }

    public function removeAll() {
        self::$_profiler = array();
        self::$_vars = array();
    }

    public function add($var, $title) {
        self::$_vars[self::$_prefix . $title] = $var;
        return self;
    }

    public function getServerData() {
        return array(
            "_SERVER" => $_SERVER,
            "_SESSION" => $_SESSION,
            "_COOKIE" => $_COOKIE,
            "_GET" => $_GET,
            "_POST" => $_POST,
            "headers_list" => headers_list()
        );
    }

    public function addToProfiler($title) {
        self::$_profiler[self::$_prefix . $title] = array(
            "memory_0" => memory_get_usage(),
            "memory" => memory_get_usage(true),
            "memory_peak_0" => memory_get_peak_usage(),
            "memory_peak" => memory_get_peak_usage(true),
            "time" => microtime(true),
        );
       return self;
    }

    public function getItem($id) {
        return self::$_vars[$id];
    }

    public function getList() {
        return self::$_vars;
    }

    public function getProfiler() {
        return self::$_profiler;
    }
}
?>
