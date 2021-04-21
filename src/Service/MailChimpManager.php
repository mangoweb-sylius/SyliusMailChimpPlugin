<?php

declare(strict_types=1);

namespace MangoSylius\MailChimpPlugin\Service;

use DrewM\MailChimp\MailChimp;
use MangoSylius\MailChimpPlugin\Exception\MailChimpException;
use MangoSylius\MailChimpPlugin\Exception\MailChimpInvalidErrorResponseException;
use MangoSylius\MailChimpPlugin\Model\MailChimpLanguageEnum;
use MangoSylius\MailChimpPlugin\Model\MailChimpSubscriptionStatusEnum;
use Nette\Utils\Validators;
use Symfony\Component\HttpFoundation\Response;
use Psr\Log\LoggerInterface;

class MailChimpManager
{
	/** @var MailChimp|null */
	private $mailChimp;

	/**
	 * @var LoggerInterface
	 */
	private $logger;

	public function __construct(
		MailChimpApiClientProvider $mailChimpApiClientProvider,
		LoggerInterface $logger
	) {
		$this->mailChimp = $mailChimpApiClientProvider->getClient();
		$this->logger = $logger;
	}

	public function isEmailSubscribedToList(string $email, string $listId): bool
	{
		assert($this->mailChimp instanceof MailChimp);
		assert(Validators::isEmail($email));

		$result = $this->mailChimp->get("lists/$listId/members/" . $this->mailChimp->subscriberHash($email));

		try {
			if (!$this->mailChimp->success()) {
				if (($this->mailChimp->getLastResponse()['headers']['http_code'] ?? null) === Response::HTTP_NOT_FOUND) {
					return false;
				}
				$this->throwMailChimpError($this->mailChimp->getLastResponse());
			}
		} catch (MailChimpInvalidErrorResponseException $e) {
			$this->logger->error($e->getMessage() . 'Mailchimp not seccess: method MailChimpManager::isEmailSubscribedToList', [
				'exception' => $e,
				'customerEmail' => $email,
			]);
		}

		assert($result !== false);

		return $result['status'] === MailChimpSubscriptionStatusEnum::SUBSCRIBED;
	}

	/**
	 * @param string $localeCode MailChimpLanguageEnum::SUPPORTED_LANGUAGES
	 *
	 * @return array<mixed>|null
	 *
	 * @throws MailChimpException
	 */
	public function subscribeToList(string $email, string $listId, string $localeCode, bool $doubleOptInEnabled): ?array
	{
		assert($this->mailChimp instanceof MailChimp);
		assert(Validators::isEmail($email));
		assert(in_array($localeCode, MailChimpLanguageEnum::SUPPORTED_LANGUAGES, true));
		$subscriberHash = $this->mailChimp->subscriberHash($email);

		if ($this->isEmailSubscribedToList($email, $listId)) {
			return null;
		}

		$result = $this->mailChimp->put("lists/$listId/members/$subscriberHash",
			[
				'email_address' => $email,
				'status' => $doubleOptInEnabled ? MailChimpSubscriptionStatusEnum::PENDING : MailChimpSubscriptionStatusEnum::SUBSCRIBED,
				'language' => $localeCode,
			]
		);

		try {
			if (!$this->mailChimp->success()) {
				$this->throwMailChimpError($this->mailChimp->getLastResponse());
			}
		} catch (MailChimpInvalidErrorResponseException $e) {
			$this->logger->error($e->getMessage() . 'Mailchimp not seccess: method MailChimpManager::subscribeToList', [
				'exception' => $e,
				'customerEmail' => $email,
			]);
		}

		return is_array($result) ? $result : null;
	}

	/**
	 * @return array<mixed>|null
	 */
	public function unsubscribeFromList(string $email, string $listId): ?array
	{
		assert($this->mailChimp instanceof MailChimp);
		assert(Validators::isEmail($email));

		$subscriberHash = $this->mailChimp->subscriberHash($email);

		$result = $this->mailChimp->patch("lists/$listId/members/$subscriberHash",
			[
				'status' => MailChimpSubscriptionStatusEnum::UNSUBSCRIBED,
			]
		);

		try {
			if (!$this->mailChimp->success()) {
				$this->throwMailChimpError($this->mailChimp->getLastResponse());
			}
		} catch (MailChimpInvalidErrorResponseException $e) {
			$this->logger->error($e->getMessage() . 'Mailchimp not seccess: method MailChimpManager::unsubscribeFromList', [
				'exception' => $e,
				'customerEmail' => $email,
			]);
		}

		return is_array($result) ? $result : null;
	}

	/**
	 * @return array<mixed>
	 */
	public function getLists(): array
	{
		$mailChimp = $this->mailChimp;
		if ($mailChimp === null) {
			return [];
		}

		$lists = [];
		$count = 10;
		$page = 0;

		do {
			$result = $mailChimp->get('lists', [
				'offset' => $page * $count,
				'count' => $count,
			]);

			try {
				if (!$this->mailChimp->success()) {
					$this->throwMailChimpError($this->mailChimp->getLastResponse());
				}
			} catch (MailChimpInvalidErrorResponseException $e) {
				$this->logger->error($e->getMessage() . 'Mailchimp not seccess: method MailChimpManager::getLists', [
					'exception' => $e
				]);
			}

			++$page;

			assert($result !== false);
			foreach ($result['lists'] as $list) {
				$lists[$list['id']] = $list['name'];
			}
		} while ($page * $count <= $result['total_items']);
		asort($lists);

		return $lists;
	}

	/**
	 * @param array<mixed> $errorResponse
	 */
	private function throwMailChimpError(array $errorResponse): void
	{
		if ($errorResponse['body'] === null) {
			throw new MailChimpInvalidErrorResponseException();
		}

		$errorArray = json_decode($errorResponse['body'], true);

		throw new MailChimpException(
			$errorArray['status'],
			$errorArray['detail'],
			$errorArray['type'],
			$errorArray['title'],
			$errorArray['errors'] ?? null,
			$errorArray['instance']
		);
	}
}
