<?php

declare(strict_types=1);

namespace MangoSylius\SmsManagerPlugin\Form\Extension;

use MangoSylius\SmsManagerPlugin\Form\SmsManagerType;
use Sylius\Bundle\ChannelBundle\Form\Type\ChannelType;
use Symfony\Component\Form\AbstractTypeExtension;
use Symfony\Component\Form\FormBuilderInterface;

final class SmsManagerChannelTypeExtension extends AbstractTypeExtension
{
	/**
	 * {@inheritdoc}
	 */
	public function buildForm(FormBuilderInterface $builder, array $options): void
	{
		$builder->add('smsManager', SmsManagerType::class);
	}

	/**
	 * {@inheritdoc}
	 */
	public function getExtendedType(): string
	{
		return ChannelType::class;
	}
}
