<?php

declare(strict_types=1);

namespace MangoSylius\MailChimpPlugin\Service;

interface ChannelMailChimpSettingsProviderInterface
{
	public function isMailChimpEnabled(): bool;

	public function getListId(): ?string;

	public function isDoubleOptInEnabled(): bool;
}
