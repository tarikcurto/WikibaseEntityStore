<?php

namespace Wikibase\EntityStore;

use Wikibase\DataModel\Entity\ItemLookup;
use Wikibase\DataModel\Entity\PropertyLookup;

/**
 * @licence GPLv2+
 * @author Thomas Pellissier Tanon
 */
abstract class EntityStore {

	/**
	 * Only stores/and returns labels, descriptions and aliases in these languages
	 */
	const OPTION_LANGUAGES = 'languages';

	/**
	 * Enables the language fallback system
	 */
	const OPTION_LANGUAGE_FALLBACK = 'languagefallback';

	/**
	 * @var EntityStoreOptions
	 */
	private $options;

	/**
	 * @param EntityStoreOptions $options
	 */
	public function __construct( EntityStoreOptions $options = null ) {
		$this->options = $options ?: new EntityStoreOptions();

		$this->setupOptions();
	}

	private function setupOptions() {
		$this->defaultOption( self::OPTION_LANGUAGES, null );
		$this->defaultOption( self::OPTION_LANGUAGE_FALLBACK, false );
	}

	/**
	 * @return EntityDocumentLookup
	 */
	public function getEntityDocumentLookup() {
		throw new FeatureNotSupportedException( 'EntityDocumentLookup not supported.' );
	}

	/**
	 * @return ItemLookup
	 */
	public function getItemLookup() {
		throw new FeatureNotSupportedException( 'ItemLookup not supported.' );
	}

	/**
	 * @return PropertyLookup
	 */
	public function getPropertyLookup() {
		throw new FeatureNotSupportedException( 'PropertyLookup not supported.' );
	}

	/**
	 * @return ItemIdForTermLookup
	 */
	public function getItemIdForTermLookup() {
		throw new FeatureNotSupportedException( 'ItemIdForTermLookup not supported.' );
	}

	/**
	 * @return PropertyIdForTermLookup
	 */
	public function getPropertyIdForTermLookup() {
		throw new FeatureNotSupportedException( 'PropertyIdForTermLookup not supported.' );
	}

	/**
	 * @return EntityDocumentSaver
	 */
	public function getEntityDocumentSaver() {
		throw new FeatureNotSupportedException( 'EntityDocumentSaver not supported.' );
	}

	/**
	 * Setup the EntityStore if it has not been done yet (create database tables, query indexes...).
	 *
	 * It should not drop data if the store is already setup.
	 */
	public function setupStore() {
	}

	/**
	 * @return EntityStoreOptions
	 */
	protected function getOptions() {
		return $this->options;
	}

	/**
	 * @see EntityStoreOptions::getOption
	 */
	protected function getOption( $option ) {
		return $this->options->getOption( $option );
	}

	/**
	 * @see EntityStoreOptions::defaultOption
	 */
	protected function defaultOption( $option, $default ) {
		$this->options->defaultOption( $option, $default );
	}
}
