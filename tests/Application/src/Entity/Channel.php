<?php

declare(strict_types=1);

namespace Tests\MangoSylius\MailChimpPlugin\Application\src\Entity;

use Doctrine\ORM\Mapping as ORM;
use MangoSylius\MailChimpPlugin\Entity\ChannelMailChimpSettingsTrait;
use Sylius\Component\Core\Model\Channel as CoreChannel;

/**
 * @ORM\Table(name="sylius_channel")
 * @ORM\Entity
 */
class Channel extends CoreChannel
{
	use ChannelMailChimpSettingsTrait;
}
