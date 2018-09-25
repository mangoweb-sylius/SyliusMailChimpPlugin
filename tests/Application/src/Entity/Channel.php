<?php

declare(strict_types=1);

namespace Tests\MangoSylius\MailChimpPlugin\Application\src\Entity;

use MangoSylius\MailChimpPlugin\Entity\ChannelMailChimpSettingsTrait;
use Sylius\Component\Core\Model\Channel as CoreChannel;

class Channel extends CoreChannel
{
	use ChannelMailChimpSettingsTrait;
}
