<?php

namespace Wikibase\EntityStore;

use Wikibase\DataModel\Entity\Item;
use Wikibase\DataModel\Term\Term;

/**
 * @licence GPLv2+
 * @author Thomas Pellissier Tanon
 */
interface ItemForTermLookup {

	/**
	 * Provides items of which the label or an alias is the given term.
	 * Does a case insensitive comparison.
	 *
	 * @param Term $term
	 * @return Item[]
	 */
	public function getItemsForTerm( Term $term );
}
