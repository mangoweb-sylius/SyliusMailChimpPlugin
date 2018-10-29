<?php declare(strict_types = 1);

namespace MangoSylius\MailChimpPlugin\Service;

use DrewM\MailChimp\MailChimp;


interface MailChimpApiClientProviderInterface
{
	public function __construct(array $config);

	public function getClient(): ?MailChimp;
}
