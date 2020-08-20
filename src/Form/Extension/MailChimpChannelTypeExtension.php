<?php

declare(strict_types=1);

namespace MangoSylius\MailChimpPlugin\Form\Extension;

use MangoSylius\MailChimpPlugin\Service\MailChimpManager;
use Sylius\Bundle\ChannelBundle\Form\Type\ChannelType;
use Symfony\Component\Form\AbstractTypeExtension;
use Symfony\Component\Form\ChoiceList\Loader\CallbackChoiceLoader;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;

final class MailChimpChannelTypeExtension extends AbstractTypeExtension
{
	/** @var MailChimpManager */
	private $mailChimpManager;

	public function __construct(MailChimpManager $mailChimpManager)
	{
		$this->mailChimpManager = $mailChimpManager;
	}

	/** @return array<string> */
	public static function getExtendedTypes(): array
	{
		return [
			ChannelType::class,
		];
	}

	/** @param array<mixed> $options */
	public function buildForm(FormBuilderInterface $builder, array $options): void
	{
		$builder
			->add('isMailChimpEnabled', CheckboxType::class, [
				'label' => 'mango.mailChimp.admin.form.channel.enabled.label',
			])
			->add('isMailChimpListDoubleOptInEnabled', CheckboxType::class, [
				'label' => 'mango.mailChimp.admin.form.channel.double_optin.label',
			])
			->add('mailChimpListId', ChoiceType::class, [
				'label' => 'mango.mailChimp.admin.form.channel.list.label',
				'placeholder' => 'mango.mailChimp.admin.form.channel.list.placeholder',
				'choice_loader' => new CallbackChoiceLoader(function () {
					return array_flip($this->mailChimpManager->getLists());
				}),
			]);
	}
}
