<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

// Выводим панель только админам 
if (!CUser::IsAdmin()) die();

$arResult["info"] = array(
	"memory" => memory_get_peak_usage(true),
	"time" => microtime(true) - $_SERVER['REQUEST_TIME'],
);

$arResult["panels"] = array(
	"PHP" => array("name" => "PHP", "info" => PHP_VERSION),
	"Status" => array("name" => "Status", "info" => http_response_code()),
	"Memory" => array(
		"name" => "Memory", 
		"info" => number_format($arResult["info"]["memory"], 0, '.', ' '),
		"class" => "label-info"
	),
	"Time gen" => array(
		"name" => "Time gen", 
		"info" => number_format( $arResult["info"]["time"], 3), 
		"class" => "label-info"
	),
	"Time render" => array(
		"name" => "Time render",
		"info" => 0, 
		"class" => "label-info time-render"
	),
);

if ($profiler = CDebug::getProfiler()) {
	$arResult["panels"]["profiler"] = array(
		"name" => "Profiler",
		"info" => count($profiler),
		"class" => "label-warning profiler"
	);
}

CDebug::setPrefix("debug_");
CDebug::add($profiler, "profiler");
CDebug::add(CDebug::getServerData(), "SERVER_DATA");

if ($list = CDebug::getList()) {
	$arResult["panels"]["debug"] = array(
		"name" => "Debug",
		"info" => count($list),
		"class" => "label-danger debug"
	);
	$arResult["debug"] = $list;
}

$this->IncludeComponentTemplate();
?>