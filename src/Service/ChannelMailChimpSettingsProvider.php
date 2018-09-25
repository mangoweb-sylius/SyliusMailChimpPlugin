<?php

declare(strict_types=1);

namespace MangoSylius\MailChimpPlugin\Service;

use MangoSylius\MailChimpPlugin\Entity\ChannelMailChimpSettingsInterface;
use Psr\Log\LoggerInterface;
use Sylius\Component\Channel\Context\ChannelContextInterface;
use Sylius\Component\Channel\Context\ChannelNotFoundException;
use Sylius\Component\Core\Model\Channel;

class ChannelMailChimpSettingsProvider implements ChannelMailChimpSettingsProviderInterface
{
	/** @var ChannelMailChimpSettingsInterface */
	private $channel;

	public function __construct(
		ChannelContextInterface $channelContext,
		LoggerInterface $logger
	) {
		try {
			$channel = $channelContext->getChannel();
		} catch (ChannelNotFoundException $e) {
			$channel = new Channel();
			$logger->error('ChannelMailchimpSettingsProvider did not get channel', ['exception' => $e]);
		}

		assert($channel instanceof ChannelMailChimpSettingsInterface);
		$this->channel = $channel;
	}

	public function getListId(): ?string
	{
		return $this->channel->getMailchimpListId();
	}

	public function isDoubleOptInEnabled(): bool
	{
		return $this->channel->isMailchimpListDoubleOptInEnabled();
	}

	public function isMailchimpEnabled(): bool
	{
		return $this->channel->isMailchimpEnabled();
	}
}
