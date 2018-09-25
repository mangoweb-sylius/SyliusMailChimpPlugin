<?php

declare(strict_types=1);

namespace MangoSylius\MailChimpPlugin\Service;

use Sylius\Component\Core\Context\ShopperContextInterface;

class MailChimpChannelSubscriber
{
	/** @var MailChimpManager */
	private $mailChimpManager;

	/** @var ShopperContextInterface */
	private $shopperContext;

	/** @var string|null */
	private $listId;

	/** @var bool */
	private $isDoubleOptInEnabled;

	/** @var bool */
	private $isMailChimpEnabled;

	public function __construct(
		MailChimpManager $mailChimpManager,
		ShopperContextInterface $shopperContext,
		ChannelMailChimpSettingsProviderInterface $channelMailChimpSettingsProvider
	) {
		$this->mailChimpManager = $mailChimpManager;
		$this->shopperContext = $shopperContext;
		$this->listId = $channelMailChimpSettingsProvider->getListId();
		$this->isDoubleOptInEnabled = $channelMailChimpSettingsProvider->isDoubleOptInEnabled();
		$this->isMailChimpEnabled = $channelMailChimpSettingsProvider->isMailChimpEnabled();
	}

	public function isSubscribed(string $email): bool
	{
		assert($this->isMailChimpEnabled && $this->listId !== null);

		return $this->mailChimpManager->isEmailSubscribedToList($email, $this->listId);
	}

	public function subscribe(string $email)
	{
		assert($this->isMailChimpEnabled && $this->listId !== null);
		$this->mailChimpManager->subscribeToList($email, $this->listId, $this->shopperContext->getLocaleCode(), $this->isDoubleOptInEnabled);
	}

	public function unsubscribe(string $email)
	{
		assert($this->isMailChimpEnabled && $this->listId !== null);
		$this->mailChimpManager->unsubscribeFromList($email, $this->listId);
	}
}
