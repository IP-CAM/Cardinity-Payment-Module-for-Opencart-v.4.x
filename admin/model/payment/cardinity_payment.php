<?php
namespace Opencart\Admin\Model\Extension\OcCardinityPayment\Payment;
class CardinityPayment extends \Opencart\System\Engine\Model {
	public function charge(int $customer_id, int $customer_payment_id, float $amount): int {
		$this->load->language('extension/oc_cardinity_payment/payment/cardinity_payment');

		$json = [];

		if (!$json) {

		}

		return $this->config->get('config_subscription_active_status_id');
	}

	public function install() {

		$this->db->query("DROP TABLE IF EXISTS `" . DB_PREFIX . "cardinity_order`;");
		$this->db->query("DROP TABLE IF EXISTS `" . DB_PREFIX . "cardinity_session`;");

		$this->createMissingTables();
	}

	public function uninstall() {
		$this->db->query("DROP TABLE IF EXISTS `" . DB_PREFIX . "cardinity_order`;");
		$this->db->query("DROP TABLE IF EXISTS `" . DB_PREFIX . "cardinity_session`;");
	}

	public function createMissingTables(){
		$this->db->query("
			CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "cardinity_order` (
			`cardinity_order_id` INT(11) NOT NULL AUTO_INCREMENT,
			`order_id` INT(11) NOT NULL,
			`payment_id` VARCHAR(255),
			`payment_status` VARCHAR(255),
			PRIMARY KEY (`cardinity_order_id`)
			) ENGINE=MyISAM DEFAULT COLLATE=utf8_general_ci;
		");

		$this->db->query("
			CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "cardinity_session` (
			`cardinity_session_id` INT(11) NOT NULL AUTO_INCREMENT,
			`session_id` VARCHAR(255) NOT NULL,
			`session_data` TEXT,
			PRIMARY KEY (`cardinity_session_id`)
			) ENGINE=MyISAM DEFAULT COLLATE=utf8_general_ci;
		");		
	}
}
