<?php
/**
 * @package  Paywall Plugin
 */
class PaywallPluginActivate
{
	public static function activate() {
		flush_rewrite_rules();
	}
}