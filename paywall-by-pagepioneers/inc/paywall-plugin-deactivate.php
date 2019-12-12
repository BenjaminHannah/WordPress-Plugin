<?php
/**
 * @package  Paywall Plugin
 */
class PaywallPluginDeactivate
{
	public static function deactivate() {
		flush_rewrite_rules();
	}
}