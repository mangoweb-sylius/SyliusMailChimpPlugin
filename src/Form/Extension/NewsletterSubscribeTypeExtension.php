<?php

declare(strict_types=1);

namespace MangoSylius\MailChimpPlugin\Form\Extension;

use Sylius\Bundle\CoreBundle\Form\Type\Customer\CustomerCheckoutGuestType;
use Symfony\Component\Form\AbstractTypeExtension;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\FormBuilderInterface;

class NewsletterSubscribeTypeExtension extends AbstractTypeExtension
{
	/** @return array<string> */
	public static function getExtendedTypes(): array
	{
		return [
			CustomerCheckoutGuestType::class,
		];
	}

	/** @param array<mixed> $options */
	public function buildForm(FormBuilderInterface $builder, array $options): void
	{
		$builder->add('subscribedToNewsletter', CheckboxType::class, [
			'label' => 'sylius.form.customer.subscribed_to_newsletter',
			'required' => false,
			'data' => true,
		]);
	}
}
