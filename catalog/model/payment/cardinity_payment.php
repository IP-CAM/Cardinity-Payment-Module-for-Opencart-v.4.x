<?php
namespace Opencart\Catalog\Model\Extension\OcCardinityPayment\Payment;
class CardinityPayment extends \Opencart\System\Engine\Model {


	public function getMethod(array $address): array {
		$this->load->language('extension/oc_cardinity_payment/payment/cardinity_payment');

		$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "zone_to_geo_zone` WHERE `geo_zone_id` = '" . (int)$this->config->get('payment_cardinity_payment_geo_zone_id') . "' AND `country_id` = '" . (int)$address['country_id'] . "' AND (`zone_id` = '" . (int)$address['zone_id'] . "' OR `zone_id` = '0')");

		if (!$this->config->get('payment_cardinity_payment_geo_zone_id')) {
			$status = true;
		} elseif ($query->num_rows) {
			$status = true;
		} else {
			$status = false;
		}

		$method_data = [];

		if ($status) {
			$method_data = [
				'code'       => 'cardinity_payment',
				'title'      => $this->language->get('heading_title'),
				'sort_order' => $this->config->get('payment_cardinity_payment_sort_order')
			];
		}

		return $method_data;
	}


	
	public function log($data, $class_step = 6, $function_step = 6) {
		//if ($this->config->get('payment_cardinity_debug')) {
			$backtrace = debug_backtrace();
			$log = new Log('cardinity.log');
			$log->write('(' . $backtrace[$class_step]['class'] . '::' . $backtrace[$function_step]['function'] . ') - ' . print_r($data, true));
		//}
	}
}
