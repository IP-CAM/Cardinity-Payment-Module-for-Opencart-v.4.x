<?php
namespace Opencart\Admin\Controller\Extension\OcCardinityPayment\Payment;

class CardinityPayment extends \Opencart\System\Engine\Controller {
	public function index(): void {
		$this->load->language('extension/oc_cardinity_payment/payment/cardinity_payment');

		$this->document->setTitle($this->language->get('heading_title'));

		$data['breadcrumbs'] = [];

		$data['breadcrumbs'][] = [
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'user_token=' . $this->session->data['user_token'])
		];

		$data['breadcrumbs'][] = [
			'text' => $this->language->get('text_extension'),
			'href' => $this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=payment')
		];

		$data['breadcrumbs'][] = [
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('extension/oc_cardinity_payment/payment/cardinity_payment', 'user_token=' . $this->session->data['user_token'])
		];

		$data['save'] = $this->url->link('extension/oc_cardinity_payment/payment/cardinity_payment|save', 'user_token=' . $this->session->data['user_token']);
		$data['back'] = $this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=payment');


		//restore form with previous data
		$data['payment_cardinity_payment_approved_status_id'] = $this->config->get('payment_cardinity_payment_approved_status_id');
		$data['payment_cardinity_payment_failed_status_id'] = $this->config->get('payment_cardinity_payment_failed_status_id');
		$data['payment_cardinity_payment_geo_zone_id'] = $this->config->get('payment_cardinity_payment_geo_zone_id');
		$data['payment_cardinity_payment_status'] = $this->config->get('payment_cardinity_payment_status');
		$data['payment_cardinity_payment_sort_order'] = $this->config->get('payment_cardinity_payment_sort_order');

		$data['payment_cardinity_payment_project_key_0'] = $this->config->get('payment_cardinity_payment_project_key_0');
		$data['payment_cardinity_payment_project_secret_0'] = $this->config->get('payment_cardinity_payment_project_secret_0');
	

		$this->load->model('localisation/order_status');
		$data['order_statuses'] = $this->model_localisation_order_status->getOrderStatuses();

		$this->load->model('localisation/geo_zone');
		$data['geo_zones'] = $this->model_localisation_geo_zone->getGeoZones();
				

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');
	
		$this->response->setOutput($this->load->view('extension/oc_cardinity_payment/payment/cardinity_payment', $data));
	}

	public function save(): void {
		$this->load->language('extension/oc_cardinity_payment/payment/cardinity_payment');

		$json = [];

		if (!$this->user->hasPermission('modify', 'extension/oc_cardinity_payment/payment/cardinity_payment')) {
			$json['error'] = $this->language->get('error_permission');
		}

		if (!$json) {
			$this->load->model('setting/setting');

			$this->model_setting_setting->editSetting('payment_cardinity_payment', $this->request->post);

			$json['success'] = $this->language->get('text_success');
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}
}
