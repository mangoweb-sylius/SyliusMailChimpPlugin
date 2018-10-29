<?php declare(strict_types = 1);

namespace MangoSylius\MailChimpPlugin\Entity;

use Doctrine\ORM\Mapping as ORM;


trait ChannelMailChimpSettingsTrait
{
	/**
	 * @var string|null
	 * @ORM\Column(type="string", nullable=true)
	 */
	private $mailChimpListId;

	/**
	 * @var bool
	 * @ORM\Column(type="boolean", options={"default" : false})
	 */
	private $isMailChimpListDoubleOptInEnabled = false;

	/**
	 * @var bool
	 * @ORM\Column(type="boolean", options={"default" : false})
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
