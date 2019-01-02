<?php

declare(strict_types=1);

namespace MangoSylius\SmsManagerPlugin\Form;

use MangoSylius\SmsManagerPlugin\Entity\SmsManagerInterface;
use Sylius\Bundle\ResourceBundle\Form\Type\AbstractResourceType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

final class SmsManagerType extends AbstractResourceType
{
	public function buildForm(FormBuilderInterface $builder, array $options): void
	{
		$builder
			->add('enabled', CheckboxType::class, [
				'label' => 'mango-sylius.admin.form.smsManager.enabled',
				'required' => false,
			])
			->add('apikey', TextType::class, [
				'label' => 'mango-sylius.admin.form.smsManager.apikey',
				'required' => false,
				'constraints' => [
					new NotBlank(['groups' => ['mango_sms_enabled']]),
				],
			])
			->add('gateway', ChoiceType::class, [
				'label' => 'mango-sylius.admin.form.smsManager.gateway',
				'required' => true,
				'choices' => [
					SmsManagerInterface::GATEWAY_LOWCOST => SmsManagerInterface::GATEWAY_LOWCOST,
					SmsManagerInterface::GATEWAY_ECONOMY => SmsManagerInterface::GATEWAY_ECONOMY,
					SmsManagerInterface::GATEWAY_HIGH => SmsManagerInterface::GATEWAY_HIGH,
				],
			])
			->add('sender', TextType::class, [
				'label' => 'mango-sylius.admin.form.smsManager.sender',
				'required' => false,
			])
		;
	}

	public function configureOptions(OptionsResolver $resolver): void
	{
		$resolver->setDefaults([
			'data_class' => $this->dataClass,
			'validation_groups' => function (FormInterface $form) {
				/** @var SmsManagerInterface $entity */
				$entity = $form->getData();

				$groups = $this->validationGroups;
				if ($entity->isEnabled()) {
					$groups = array_merge($groups, ['mango_sms_enabled']);
				}

				return $groups;
			},
		]);
	}

	public function getBlockPrefix(): string
	{
		return 'mango_sms_manager';
	}
}
