<?php declare(strict_types = 1);

namespace MangoSylius\MailChimpPlugin\Model;

class MailChimpSubscriptionStatusEnum
{
	/** This address is on the list and ready to receive email. You can only send campaigns to ‘subscribed’ addresses. */
	public const SUBSCRIBED = 'subscribed';

	/** This address used to be on the list but isn’t anymore. */
	public const UNSUBSCRIBED = 'unsubscribed';

	/** This address requested to be added with double-opt-in but hasn’t confirmed their subscription yet. */
	public const PENDING = 'pending';

	/** This address bounced and has been removed from the list. */
	public const CLEANED = 'cleaned';
}
