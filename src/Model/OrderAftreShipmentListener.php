<?php

declare(strict_types=1);

namespace MangoSylius\SmsManagerPlugin\Model;

use Sylius\Component\Core\Model\ShipmentInterface;
use Symfony\Component\EventDispatcher\GenericEvent;

class OrderAftreShipmentListener
{
	/** @var SmsSenderInterface */
	private $smsSender;

	public function __construct(
		SmsSenderInterface $smsSender
	) {
		$this->smsSender = $smsSender;
	}

	public function sendConfirmationSms(GenericEvent $event): void
	{
		$shipment = $event->getSubject();
		assert($shipment instanceof ShipmentInterface);

		$this->smsSender->sendSms($shipment);
	}
}
