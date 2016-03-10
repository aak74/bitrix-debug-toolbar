<?
if (CUser::IsAdmin()) {
	$APPLICATION->IncludeComponent(
		"akop:debug.toolbar", 
		"", 
		array(), 
		false
	);
}
?>
