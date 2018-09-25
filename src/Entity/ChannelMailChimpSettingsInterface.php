<?php

declare(strict_types=1);

namespace MangoSylius\MailChimpPlugin\Entity;

interface ChannelMailChimpSettingsInterface
{
	public function setMailChimpListId(?string $listId): void;

	public function getMailChimpListId(): ?string;

	public function setIsMailChimpListDoubleOptInEnabled(bool $isDoubleOptInEnabled): void;

	public function isMailChimpListDoubleOptInEnabled(): bool;

	public function setIsMailChimpEnabled(bool $isMailChimpEnabled): void;

	public function isMailChimpEnabled(): bool;
}
