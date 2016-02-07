<?php

namespace Emulator\HabboHotel\Catalog;

use Emulator\HabboHotel\Catalog\CatalogPageLayouts;
use Emulator\Emulator;
use Ubench;

class CatalogManager {

    private $catalogPages;
    private $prizes;
    private $giftWrappers;
    private $giftFurnis;
    private $clubItems;
    private $offerDefs;
    private $vouchers;
    private $ecotronItem;
    public static $catalogItemCount;

    public function __construct() {
        $bench = new Ubench();
        $bench->start();

        $this->catalogPages = array();
        $this->prizes = array();
        $this->giftWrappers = array();
        $this->giftFurnis = array();
        $this->clubItems = array();
        $this->offerDefs = array();
        $this->vouchers = array();
        $this->initialize();

        $bench->end();
        Emulator::getLogging()->logStart("Catalog Manager -> Loaded! (" . $bench->getTime() . ")");
    }

    public function initialize() {
        $this->loadCatalogPages();
    }

    private function loadCatalogPages() {
        $query = Emulator::getDatabase()->query("SELECT * FROM catalog_pages ORDER BY parent_id, id;");

        foreach ($query as $page) {
            switch (new CatalogPageLayouts($page->page_layout)) {
                case CatalogPageLayouts::default_3x3:
                    break;
            }
        }
    }

}
