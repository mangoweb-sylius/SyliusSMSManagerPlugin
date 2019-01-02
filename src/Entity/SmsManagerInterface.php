<?php

declare(strict_types=1);

namespace MangoSylius\SmsManagerPlugin\Entity;

interface SmsManagerInterface
{
	public const GATEWAY_HIGH = 'high';
	public const GATEWAY_ECONOMY = 'economy';
	public const GATEWAY_LOWCOST = 'lowcost';

	public function getGateway(): string;

	public function getApikey(): ?string;

	public function isEnabled(): bool;

	public function getSender(): ?string;
}
