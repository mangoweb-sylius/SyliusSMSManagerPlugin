<?php

declare(strict_types=1);

namespace MangoSylius\SmsManagerPlugin\Entity;

use Doctrine\ORM\Mapping as ORM;
use Sylius\Component\Resource\Model\ResourceInterface;

/**
 * @ORM\Table(name="mango_sms_manager")
 * @ORM\Entity
 */
class SmsManager implements SmsManagerInterface, ResourceInterface
{
	/**
	 * @var int
	 *
	 * @ORM\Column(name="id", type="integer")
	 * @ORM\Id
	 * @ORM\GeneratedValue(strategy="AUTO")
	 */
	private $id;

	/**
	 * @var string
	 * @ORM\Column(type="string", name="gateway", nullable=true)
	 */
	private $gateway = SmsManagerInterface::GATEWAY_LOWCOST;

	/**
	 * @var string|null
	 * @ORM\Column(type="string", name="apikey", nullable=true)
	 */
	private $apikey;

	/**
	 * @var string|null
	 * @ORM\Column(type="string", name="sender", nullable=true)
	 */
	private $sender;

	/**
	 * @var bool
	 *
	 * @ORM\Column(type="boolean", name="enabled", nullable=true)
	 */
	private $enabled = false;

	public function getId(): int
	{
		return $this->id;
	}

	public function getGateway(): string
	{
		return $this->gateway;
	}

	public function setGateway(string $gateway): void
	{
		$this->gateway = $gateway;
	}

	public function getApikey(): ?string
	{
		return $this->apikey;
	}

	public function setApikey(?string $apikey): void
	{
		$this->apikey = $apikey;
	}

	public function getSender(): ?string
	{
		return $this->sender;
	}

	public function setSender(?string $sender): void
	{
		$this->sender = $sender;
	}

	public function isEnabled(): bool
	{
		return $this->enabled;
	}

	public function setEnabled(bool $enabled): void
	{
		$this->enabled = $enabled;
	}
}
