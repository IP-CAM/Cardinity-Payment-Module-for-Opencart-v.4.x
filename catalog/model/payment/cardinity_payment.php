<?php
namespace Opencart\Catalog\Model\Extension\OcCardinityPayment\Payment;

class CardinityPayment extends \Opencart\System\Engine\Model {


	public function getMethods(array $address): array {
		$this->load->language('extension/oc_cardinity_payment/payment/cardinity_payment');
		
		
		if (!$this->config->get('payment_cardinity_payment_geo_zone_id')) {
			$status = true;
		} elseif(isset($address['country_id']) && isset($address['zone_id'])) {
			$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "zone_to_geo_zone` WHERE `geo_zone_id` = '" . (int)$this->config->get('payment_cardinity_payment_geo_zone_id') . "' AND `country_id` = '" . (int)$address['country_id'] . "' AND (`zone_id` = '" . (int)$address['zone_id'] . "' OR `zone_id` = '0')");
			if ($query->num_rows) {
				$status = true;
			} else {
				$status = false;
			}
		}else{
			$status = false;
		}

		$method_data = [];

		if ($status) {
			$option_data['cardinity_payment'] = [
				'code' => 'cardinity_payment.cardinity_payment',
				'name' => $this->language->get('heading_title')
			];

			$method_data = [
				'code'       => 'cardinity_payment',
				'name'       => $this->language->get('heading_title'),
				'option'     => $option_data,
				'sort_order' => $this->config->get('payment_cardinity_payment_sort_order')
			];
		}

		return $method_data;
	}

	public function storeSession($data) {

		$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "cardinity_session` WHERE `session_id` = '" . $data['session_id'] . "' ORDER BY `cardinity_session_id` ASC  LIMIT 1");

		if($query->num_rows){
			$this->db->query("UPDATE  `" . DB_PREFIX . "cardinity_session` SET `session_data` = '" .  $this->db->escape($data['session_data'])  . "' WHERE `session_id` = '" . $data['session_id'] . "'");
		}else{
			$this->db->query("INSERT INTO `" . DB_PREFIX . "cardinity_session` SET `session_id` = '" . $data['session_id'] . "', `session_data` = '" . $this->db->escape($data['session_data']) . "'");
		}

	}

	public function fetchSession($sessionId) {
		$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "cardinity_session` WHERE `session_id` = '" . $sessionId . "' ORDER BY `cardinity_session_id` ASC  LIMIT 1");

		return $query->row;
	}

	
	public function log($data, $class_step = 6, $function_step = 6) {
		if ($this->config->get('payment_cardinity_debug')) {
			$backtrace = debug_backtrace();
			$log = new Log('cardinity.log');
			$log->write('(' . $backtrace[$class_step]['class'] . '::' . $backtrace[$function_step]['function'] . ') - ' . print_r($data, true));
		}
	}
}
