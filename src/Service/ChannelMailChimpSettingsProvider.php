<?php declare(strict_types = 1);

namespace MangoSylius\MailChimpPlugin\Service;

use MangoSylius\MailChimpPlugin\Entity\ChannelMailChimpSettingsInterface;
use Psr\Log\LoggerInterface;
use Sylius\Component\Channel\Context\ChannelContextInterface;
use Sylius\Component\Channel\Context\ChannelNotFoundException;


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
			assert($channel instanceof ChannelMailChimpSettingsInterface);
			$this->channel = $channel;

		} catch (ChannelNotFoundException $e) {
			$logger->error('ChannelMailchimpSettingsProvider did not get channel', ['exception' => $e]);
		}
	}

	public function getListId(): ?string
	{
		if ($this->channel) {
			return $this->channel->getMailchimpListId();
		}

		return null;
	}

	public function isDoubleOptInEnabled(): bool
	{
		if ($this->channel) {
			return $this->channel->isMailchimpListDoubleOptInEnabled();
		}

		return false;
	}

	public function isMailchimpEnabled(): bool
	{
		if ($this->channel) {
			return $this->channel->isMailchimpEnabled();
		}

		return false;
	}
}
