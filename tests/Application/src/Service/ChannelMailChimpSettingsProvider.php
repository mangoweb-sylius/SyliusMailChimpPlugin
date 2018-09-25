<?php

declare(strict_types=1);

namespace Tests\MangoSylius\MailChimpPlugin\Application\src\Service;

use MangoSylius\MailChimpPlugin\Service\ChannelMailChimpSettingsProviderInterface;
use Psr\Log\LoggerInterface;
use Sylius\Component\Channel\Context\ChannelContextInterface;
use Sylius\Component\Channel\Context\ChannelNotFoundException;
use Tests\MangoSylius\MailChimpPlugin\Application\src\Entity\Channel;

class ChannelMailChimpSettingsProvider implements ChannelMailChimpSettingsProviderInterface
{
	/** @var Channel */
	private $channel;

	public function __construct(
		ChannelContextInterface $channelContext,
		LoggerInterface $logger
	) {
		try {
			$channel = $channelContext->getChannel();
		} catch (ChannelNotFoundException $e) {
			$channel = new Channel();
			$logger->error('ChannelMailChimpSettingsProvider did not get channel', ['exception' => $e]);
		}

		assert($channel instanceof Channel);
		$this->channel = $channel;
	}

	public function getListId(): ?string
	{
		return $this->channel->getMailChimpListId();
	}

	public function isDoubleOptInEnabled(): bool
	{
		return $this->channel->isMailChimpListDoubleOptInEnabled();
	}

	public function isMailChimpEnabled(): bool
	{
		return $this->channel->isMailChimpEnabled();
	}
}
