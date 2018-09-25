<?php

declare(strict_types=1);

namespace MangoSylius\MailChimpPlugin\Service;

use DrewM\MailChimp\MailChimp;

class MailChimpApiClientProvider implements MailChimpApiClientProviderInterface
{
	/**
	 * @var string|null
	 */
	private $apiKey;

	/**
	 * @var MailChimp|null
	 */
	private $client;

	public function __construct(array $config)
	{
		$this->apiKey = $config['mailchimp_api_key'];
	}

	public function getClient(): ?MailChimp
	{
		if ($this->apiKey !== null && $this->client !== null) {
			$this->client = new MailChimp($this->apiKey);

			return $this->client;
		}

		return null;
	}
}
