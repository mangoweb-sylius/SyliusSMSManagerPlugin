<?php

declare(strict_types=1);

namespace MangoSylius\SmsManagerPlugin\Model;

use MangoSylius\SmsManagerPlugin\Entity\SmsManager;

interface SmsManagerChannelInterface
{
	public function getSmsManager(): ?SmsManager;
}
