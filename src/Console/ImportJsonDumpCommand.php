<?php

namespace Wikibase\EntityStore\Console;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Logger\ConsoleLogger;
use Symfony\Component\Console\Output\OutputInterface;
use Wikibase\EntityStore\Config\EntityStoreFromConfigurationBuilder;
use Wikibase\EntityStore\Internal\EntitySerializationFactory;
use Wikibase\EntityStore\Internal\JsonDumpReader;

/**
 * @licence GPLv2+
 * @author Thomas Pellissier Tanon
 */
class ImportJsonDumpCommand extends Command {

	protected function configure() {
		$this->setName( 'import-json-dump' )
			->setDescription( 'Import a JSON dump in an entity store' )
			->addArgument( 'file', InputArgument::REQUIRED, 'JSON dump file' )
			->addArgument( 'configuration', InputArgument::REQUIRED, 'Configuration file' );
	}

	protected function execute( InputInterface $input, OutputInterface $output ) {
		$configurationBuilder = new EntityStoreFromConfigurationBuilder();
		$store = $configurationBuilder->buildEntityStore( $input->getArgument( 'configuration' ) );

		$store->setupStore();

		$entitySaver = $store->getEntityDocumentSaver();
		$serialization = new EntitySerializationFactory();

		$dumpReader = new JsonDumpReader(
			$input->getArgument( 'file' ),
			$serialization->newEntityDeserializer(),
			new ConsoleLogger( $output )
		);
		$count = 0;
		foreach( $dumpReader as $entity ) {
			$entitySaver->saveEntityDocument( $entity );
			$count++;

			if($count % 1000 === 0 ) {
				$output->write( '.' );
			}
		}

		$output->writeln( 'Importation done' );
	}
}
