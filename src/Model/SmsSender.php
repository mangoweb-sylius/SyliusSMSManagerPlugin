<?php

declare(strict_types=1);

namespace MangoSylius\SmsManagerPlugin\Model;

use MangoSylius\SmsManagerPlugin\Entity\SmsManagerInterface;
use Psr\Log\LoggerInterface;
use Sylius\Component\Core\Model\OrderInterface;
use Sylius\Component\Core\Model\ShipmentInterface;

class SmsSender implements SmsSenderInterface
{
	public const API_URL = 'https://http-api.smsmanager.cz/';
	public const API_ROUTE_SEND = 'Send';

	/** @var LoggerInterface */
	private $logger;

	public function __construct(
		LoggerInterface $logger
	) {
		$this->logger = $logger;
	}

	public function sendSms(ShipmentInterface $shipment): void
	{
		$order = $shipment->getOrder();
		assert($order !== null);
		$trackingNumber = $shipment->getTracking();

		$channel = $order->getChannel();
		assert($channel !== null);
		assert($channel instanceof SmsManagerChannelInterface);

		$shipmentMethod = $shipment->getMethod();
		assert($shipmentMethod !== null);

		$orderLocale = $order->getLocaleCode();
		assert($orderLocale !== null);
		$translation = $shipmentMethod->getTranslation($orderLocale);
		assert($translation !== null);
		assert($translation instanceof SmsManagerShippingMethodInterface);

		if ($translation->getLocale() === $orderLocale) {
			$smsText = $translation->getSmsText();
			$smsApi = $channel->getSmsManager();
			if ($smsText !== null && $smsApi !== null && $smsApi->isEnabled()) {
				$this->doSendGetSms($smsApi, $order, $smsText, $trackingNumber);
			}
		}
	}

	/**
	 * Správný formát telefonního čísla je: 420777111222, případně bez 420, přípustné + nebo 00 na začátku
	 */
	private function getPhoneNumber(OrderInterface $order): ?string
	{
		$phoneNumber = null;

		$address = $order->getShippingAddress();
		if ($address !== null && $address->getPhoneNumber() !== null) {
			$phoneNumber = $address->getPhoneNumber();
		}

		$address = $order->getBillingAddress();
		if ($phoneNumber === null && $address !== null && $address->getPhoneNumber() !== null) {
			$phoneNumber = $address->getPhoneNumber();
		}

		if ($phoneNumber === null) {
			return null;
		}

		$phoneNumber = trim($phoneNumber);
		$phoneNumber = preg_replace('/\s/', '', $phoneNumber);

		assert($phoneNumber !== null);

		$pattern = '/^(((\+)|(00))42(0|1))?\d{9}$/';
		if (!preg_match($pattern, $phoneNumber)) {
			$this->logger->error('No SMS send, bad number format: ' . $phoneNumber);

			return null;
		}

		return $phoneNumber;
	}

	private function getMessage(OrderInterface $order, string $smsText, ?string $trackingNumber): string
	{
		$address = $order->getShippingAddress();
		assert($address !== null);

		$smsText = str_replace('{{ orderNumber }}', $order->getNumber() ?? '', $smsText);
		$smsText = str_replace('{{ address.street }}', $address->getStreet() ?? '', $smsText);
		$smsText = str_replace('{{ address.city }}', $address->getCity() ?? '', $smsText);
		$smsText = str_replace('{{ address.company }}', $address->getCompany() ?? '', $smsText);
		$smsText = str_replace('{{ address.countryCode }}', $address->getCountryCode() ?? '', $smsText);
		$smsText = str_replace('{{ address.fullName }}', $address->getFullName() ?? '', $smsText);
		$smsText = str_replace('{{ address.postCode }}', $address->getPostcode() ?? '', $smsText);
		$smsText = str_replace('{{ address.provinceCode }}', $address->getProvinceCode() ?? '', $smsText);
		$smsText = str_replace('{{ address.provinceName }}', $address->getProvinceName() ?? '', $smsText);
		$smsText = str_replace('{{ trackingNumber }}', $trackingNumber ?? '', $smsText);

		return $smsText;
	}

	/**
	 * https://smsmanager.cz/api/http#send
	 */
	private function createSendUrl(OrderInterface $order, SmsManagerInterface $smsApi, string $number, string $smsText, ?string $trackingNumber): string
	{
		$message = urlencode($this->getMessage($order, $smsText, $trackingNumber));
		$apiKey = $smsApi->getApikey();
		$gateway = $smsApi->getGateway();
		$sender = $smsApi->getSender();

		$getParameters = '?apikey=' . $apiKey . '&number=' . $number . '&message=' . $message . '&gateway=' . $gateway;
		if ($sender !== null) {
			$getParameters .= '?sender=' . $sender;
		}

		return $this::API_URL . $this::API_ROUTE_SEND . $getParameters;
	}

	private function doSendGetSms(SmsManagerInterface $smsApi, OrderInterface $order, string $smsText, ?string $trackingNumber): void
	{
		$number = $this->getPhoneNumber($order);
		if ($number === null) {
			return;
		}

		$url = $this->createSendUrl($order, $smsApi, $number, $smsText, $trackingNumber);

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-type: plain/text']);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

		$response = (string) curl_exec($ch);
		if (strpos($response, 'error') !== false) {
			$this->logger->error($response);
		}
	}
}
