<?php

declare(strict_types=1);

namespace MangoSylius\MailChimpPlugin\Entity;

trait ChannelMailChimpSettingsTrait
{
	/**
	 * @var string|null
	 */
	private $mailChimpListId;

	/**
	 * @var bool
	 */
	private $isMailChimpListDoubleOptInEnabled = false;

	/**
	 * @var bool
	 */
	private $isMailChimpEnabled = false;

	public function setMailChimpListId(?string $listId): void
	{
		$this->mailChimpListId = $listId;
	}

	public function getMailChimpListId(): ?string
	{
		return $this->mailChimpListId;
	}

	public function setIsMailChimpListDoubleOptInEnabled(bool $isDoubleOptInEnabled): void
	{
		$this->isMailChimpListDoubleOptInEnabled = $isDoubleOptInEnabled;
	}

	public function isMailChimpListDoubleOptInEnabled(): bool
	{
		return $this->isMailChimpListDoubleOptInEnabled;
	}

	public function setIsMailChimpEnabled(bool $isMailChimpEnabled): void
	{
		$this->isMailChimpEnabled = $isMailChimpEnabled;
	}

	public function isMailChimpEnabled(): bool
	{
		return $this->isMailChimpEnabled;
	}
}
