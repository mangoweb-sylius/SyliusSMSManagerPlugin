<?php

declare(strict_types=1);

namespace MangoSylius\SmsManagerPlugin\Form\Extension;

use Sylius\Bundle\ShippingBundle\Form\Type\ShippingMethodTranslationType;
use Symfony\Component\Form\AbstractTypeExtension;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;

final class SmsManagerShippingMethodTypeExtension extends AbstractTypeExtension
{
	/**
	 * {@inheritdoc}
	 */
	public function buildForm(FormBuilderInterface $builder, array $options): void
	{
		$builder
			->add('smsText', TextareaType::class, [
				'required' => false,
			]);
	}

	/**
	 * {@inheritdoc}
	 */
	public function getExtendedType(): string
	{
		return ShippingMethodTranslationType::class;
	}
}
