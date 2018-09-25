<?php

declare(strict_types=1);

namespace MangoSylius\MailChimpPlugin\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

final class Configuration implements ConfigurationInterface
{
	/**
	 * {@inheritdoc}
	 */
	public function getConfigTreeBuilder(): TreeBuilder
	{
		$treeBuilder = new TreeBuilder();
		$rootNode = $treeBuilder->root('mango_sylius_mail_chimp');
		assert($rootNode instanceof ArrayNodeDefinition);

		$rootNode
			->children()
				->scalarNode('mailchimp_api_key')
				->isRequired()
				->cannotBeEmpty()
				->end()
			->end();

		return $treeBuilder;
	}
}
