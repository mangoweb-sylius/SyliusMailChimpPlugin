<?php

declare(strict_types=1);

namespace MangoSylius\MailChimpPlugin\Model;

use MangoSylius\MailChimpPlugin\Exception\MailChimpException;
use MangoSylius\MailChimpPlugin\Service\ChannelMailChimpSettingsProviderInterface;
use MangoSylius\MailChimpPlugin\Service\MailChimpChannelSubscriber;
use Psr\Log\LoggerInterface;
use Sylius\Component\Core\Model\CustomerInterface;
use Sylius\Component\Core\Model\ShopUser;
use Symfony\Component\EventDispatcher\GenericEvent;
use Symfony\Component\Security\Http\Event\InteractiveLoginEvent;

class CustomerListener implements CustomerListenerInterface
{
	/** @var MailChimpChannelSubscriber */
	private $mailChimpChannelSubscriber;

	/** @var LoggerInterface */
	private $logger;

	/** @var bool */
	private $isMailChimpEnabled;

	public function __construct(
		MailChimpChannelSubscriber $mailChimpChannelSubscriber,
		LoggerInterface $logger,
		ChannelMailChimpSettingsProviderInterface $channelMailChimpSettingsProvider
	) {
		$this->mailChimpChannelSubscriber = $mailChimpChannelSubscriber;
		$this->logger = $logger;
		$this->isMailChimpEnabled = $channelMailChimpSettingsProvider->isMailChimpEnabled() && $channelMailChimpSettingsProvider->getListId() !== null;
	}

	public function syncSubscriptionToMailChimp(GenericEvent $event): void
	{
		if (!$this->isMailChimpEnabled) {
			return;
		}

		$customer = $event->getSubject();
		if (!($customer instanceof CustomerInterface)) {
			return;
		}

		$email = $customer->getEmailCanonical();

		try {
			$isSubscribed = $this->mailChimpChannelSubscriber->isSubscribed($email);

			if ($isSubscribed && !$customer->isSubscribedToNewsletter()) {
				$this->mailChimpChannelSubscriber->unsubscribe($email);
			} elseif (!$isSubscribed && $customer->isSubscribedToNewsletter()) {
				$this->mailChimpChannelSubscriber->subscribe($customer->getEmailCanonical());
			}
		} catch (MailChimpException $e) {
			$this->logger->error($e->getMessage() . ', when trying to sync subscription to mailChimp', [
				'exception' => $e,
				'customerId' => $customer->getId(),
			]);
		}
	}

	public function syncSubstriptionStateFromMailChimp(InteractiveLoginEvent $event): void
	{
		if (!$this->isMailChimpEnabled) {
			return;
		}

		$user = $event->getAuthenticationToken()->getUser();

		if (!($user instanceof ShopUser) || $user->getCustomer() === null) {
			return;
		}

		$customer = $user->getCustomer();
		assert($customer instanceof Customer);
		$email = $customer->getEmailCanonical();

		try {
			$isSubscribed = $this->mailChimpChannelSubscriber->isSubscribed($email);
			$customer->setSubscribedToNewsletter($isSubscribed);
		} catch (MailChimpException $e) {
			$this->logger->error($e->getMessage() . ', when trying to fetch subscription state', [
				'exception' => $e,
				'customerId' => $customer->getId(),
			]);
		}
	}
}
