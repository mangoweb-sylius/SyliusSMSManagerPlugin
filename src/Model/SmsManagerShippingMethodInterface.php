<?php

declare(strict_types=1);

namespace MangoSylius\SmsManagerPlugin\Model;

interface SmsManagerShippingMethodInterface
{
	public function getSmsText(): ?string;
}
