<?php

declare(strict_types=1);

namespace MangoSylius\SmsManagerPlugin\Model;

use Doctrine\ORM\Mapping as ORM;
use MangoSylius\SmsManagerPlugin\Entity\SmsManager;

trait SmsManagerChannelTrait
{
	/**
	 * @var SmsManager|null
	 * @ORM\OneToOne(targetEntity="MangoSylius\SmsManagerPlugin\Entity\SmsManager", cascade={"persist"}, fetch="EXTRA_LAZY")
	 */
	private $smsManager;

	public function getSmsManager(): ?SmsManager
	{
		return $this->smsManager ?? new SmsManager();
	}

	public function setSmsManager(?SmsManager $smsManager): void
	{
		$this->smsManager = $smsManager;
	}
}
