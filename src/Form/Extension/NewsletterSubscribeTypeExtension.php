<?php declare(strict_types = 1);

namespace MangoSylius\MailChimpPlugin\Form\Extension;

use Sylius\Bundle\CoreBundle\Form\Type\Customer\CustomerGuestType;
use Symfony\Component\Form\AbstractTypeExtension;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\FormBuilderInterface;


class NewsletterSubscribeTypeExtension extends AbstractTypeExtension
{
	public function buildForm(FormBuilderInterface $builder, array $options): void
	{
		$builder->add('subscribedToNewsletter', CheckboxType::class, [
			'label' => 'sylius.form.customer.subscribed_to_newsletter',
			'required' => false,
		]);
	}


	/**
	 * {@inheritdoc}
	 */
	public function getExtendedType()
	{
		return CustomerGuestType::class;
	}
}
