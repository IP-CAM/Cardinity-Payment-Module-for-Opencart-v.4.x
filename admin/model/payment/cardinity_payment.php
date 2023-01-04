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
}
