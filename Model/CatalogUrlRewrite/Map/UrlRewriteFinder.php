<?php
/**
 * Copyright © 2017-2018 Chad A. Carino. All rights reserved.
 * See LICENSE file for license details.
 *
 * @package    Bangerkuwranger/GtidSafeUrlRewriteFallback
 * @author     Chad A. Carino <artist@chadacarino.com>
 * @author     Burak Bingollu <burak.bingollu@gmail.com>
 * @copyright  2017-2018 Chad A. Carino
 * @license    https://opensource.org/licenses/MIT  MIT License
 */
namespace Bangerkuwranger\GtidSafeUrlRewriteFallback\Model\CatalogUrlRewrite\Map;

use Magento\CatalogUrlRewrite\Model\Map\UrlRewriteFinder as MageUrlRewriteFinder;
use Magento\UrlRewrite\Model\UrlFinderInterface;
use Magento\UrlRewrite\Service\V1\Data\UrlRewrite;
use Magento\UrlRewrite\Service\V1\Data\UrlRewriteFactory;
use Magento\CatalogUrlRewrite\Model\Map\DatabaseMapPool;

/**
 * Finds specific queried url rewrites identified by specific fields.
 *
 * A group of identifiers specifies a query consumed by the client to retrieve existing url rewrites from the database.
 * Clients will query a map of DatabaseMapInterface type through this class resulting into
 * a set of url rewrites results.
 * Each map type will fallback to a UrlFinderInterface by identifiers for unmapped values.
 */
class UrlRewriteFinder extends MageUrlRewriteFinder
{
    /** Category entity type name */
    const ENTITY_TYPE_CATEGORY = 'category';

    /** Product entity type name */
    const ENTITY_TYPE_PRODUCT = 'product';

    /**
     * Pool for database maps.
     *
     * @var DatabaseMapPool
     */
    private $databaseMapPool;

    /**
     * Url Finder Interface.
     *
     * @var UrlFinderInterface
     */
    private $urlFinder;

    /**
     * Class for url storage.
     *
     * @var UrlRewrite
     */
    private $urlRewritePrototype;

    /**
     * UrlRewrite class names array.
     *
     * @var array
     */
    private $urlRewriteClassNames = [];

    /**
     * @param DatabaseMapPool $databaseMapPool
     * @param UrlFinderInterface $urlFinder
     * @param UrlRewriteFactory $urlRewriteFactory
     * @param string[] $urlRewriteClassNames
     */
    public function __construct(
    	DatabaseMapPool $databaseMapPool,
        UrlFinderInterface $urlFinder,
        UrlRewriteFactory $urlRewriteFactory,
        array $urlRewriteClassNames = []
    ) {
		$this->databaseMapPool = $databaseMapPool;
        $this->urlFinder = $urlFinder;
        $this->urlRewriteClassNames = ( !empty($urlRewriteClassNames) ) ? $urlRewriteClassNames : [];
        $this->urlRewritePrototype = $urlRewriteFactory->create();
    }

    /**
     * Retrieves existing url rewrites by using UrlFinderInterface.
     *
     * @param int $entityId
     * @param int $storeId
     * @param string $entityType
     * @param int|null $rootCategoryId
     * @return \Magento\UrlRewrite\Service\V1\Data\UrlRewrite[]
     */
    public function findAllByData($entityId, $storeId, $entityType, $rootCategoryId = null)
    {
    
        return $this->urlFinder->findAllByData(
            [
                UrlRewrite::STORE_ID => $storeId,
                UrlRewrite::ENTITY_ID => $entityId,
                UrlRewrite::ENTITY_TYPE => $entityType
            ]
        );
    }

}
