<?php declare(strict_types = 1);

namespace MangoSylius\MailChimpPlugin\Model;

use Symfony\Component\EventDispatcher\GenericEvent;
use Symfony\Component\Security\Http\Event\InteractiveLoginEvent;


interface CustomerListenerInterface
{
	public function syncSubscriptionToMailChimp(GenericEvent $event): void;

	public function syncSubstriptionStateFromMailChimp(InteractiveLoginEvent $event): void;
}
