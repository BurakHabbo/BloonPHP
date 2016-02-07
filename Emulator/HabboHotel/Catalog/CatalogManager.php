<?php

namespace Emulator\HabboHotel\Catalog;

use Emulator\HabboHotel\Catalog\CatalogPageLayouts;
use Emulator\HabboHotel\Catalog\Layouts\Default_3x3Layout;
use Emulator\HabboHotel\Catalog\Layouts\FrontpageLayout;
use Emulator\HabboHotel\Catalog\Layouts\BadgeDisplayLayout;
use Emulator\HabboHotel\Catalog\Layouts\SpacesLayout;
use Emulator\HabboHotel\Catalog\Layouts\TrophiesLayout;
use Emulator\HabboHotel\Catalog\Layouts\BotsLayout;
use Emulator\HabboHotel\Catalog\Layouts\ClubBuyLayout;
use Emulator\HabboHotel\Catalog\Layouts\ClubGiftsLayout;
use Emulator\HabboHotel\Catalog\Layouts\SoldLTDItemsLayout;
use Emulator\HabboHotel\Catalog\Layouts\SingleBundle;
use Emulator\HabboHotel\Catalog\Layouts\RoomAdsLayout;
use Emulator\HabboHotel\Catalog\Layouts\RecyclerLayout;
use Emulator\HabboHotel\Catalog\Layouts\RecyclerInfoLayout;
use Emulator\HabboHotel\Catalog\Layouts\RecyclerPrizesLayout;
use Emulator\HabboHotel\Catalog\Layouts\MarketplaceLayout;
use Emulator\HabboHotel\Catalog\Layouts\MarketplaceOwnItems;
use Emulator\HabboHotel\Catalog\Layouts\InfoDucketsLayout;
use Emulator\HabboHotel\Catalog\Layouts\InfoPetsLayout;
use Emulator\HabboHotel\Catalog\Layouts\InfoRentablesLayout;
use Emulator\HabboHotel\Catalog\Layouts\GuildFrontpageLayout;
use Emulator\HabboHotel\Catalog\Layouts\GuildFurnitureLayout;
use Emulator\HabboHotel\Catalog\Layouts\PetsLayout;
use Emulator\HabboHotel\Catalog\Layouts\Pets2Layout;
use Emulator\HabboHotel\Catalog\Layouts\Pets3Layout;
use Emulator\HabboHotel\Catalog\Layouts\ProductPage1Layout;
use Emulator\HabboHotel\Catalog\Layouts\TraxLayout;
use Emulator\HabboHotel\Catalog\Layouts\ColorGroupingLayout;
use Emulator\HabboHotel\Catalog\Layouts\RecentPurchasesLayout;
use Emulator\HabboHotel\Catalog\Layouts\PetCustomizationLayout;
use Emulator\HabboHotel\Catalog\CatalogItem;
use Emulator\HabboHotel\Catalog\Voucher;
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
        $this->loadCatalogItems();
        $this->loadVouchers();
    }

    private function loadCatalogPages() {
        $query = Emulator::getDatabase()->query("SELECT * FROM catalog_pages ORDER BY parent_id, id;");

        foreach ($query as $page) {
            switch (new CatalogPageLayouts($page->page_layout)) {
                case CatalogPageLayouts::default_3x3:
                    $this->catalogPages[(int) $page->id] = new Default_3x3Layout($page);
                    break;
                case CatalogPageLayouts::frontpage:
                    $this->catalogPages[(int) $page->id] = new FrontpageLayout($page);
                    break;
                case CatalogPageLayouts::badge_display:
                    $this->catalogPages[(int) $page->id] = new BadgeDisplayLayout($page);
                    break;
                case CatalogPageLayouts::spaces_new:
                    $this->catalogPages[(int) $page->id] = new SpacesLayout($page);
                    break;
                case CatalogPageLayouts::trophies:
                    $this->catalogPages[(int) $page->id] = new TrophiesLayout($page);
                    break;
                case CatalogPageLayouts::bots:
                    $this->catalogPages[(int) $page->id] = new BotsLayout($page);
                    break;
                case CatalogPageLayouts::club_buy:
                    $this->catalogPages[(int) $page->id] = new ClubBuyLayout($page);
                    break;
                case CatalogPageLayouts::club_gift:
                    $this->catalogPages[(int) $page->id] = new ClubGiftsLayout($page);
                    break;
                case CatalogPageLayouts::sold_ltd_items:
                    $this->catalogPages[(int) $page->id] = new SoldLTDItemsLayout($page);
                    break;
                case CatalogPageLayouts::single_bundle:
                    $this->catalogPages[(int) $page->id] = new SingleBundle($page);
                    break;
                case CatalogPageLayouts::roomads:
                    $this->catalogPages[(int) $page->id] = new RoomAdsLayout($page);
                    break;
                case CatalogPageLayouts::recycler:
                    if (!Emulator::getConfig()->getBoolean("hotel.ecotron.enabled"))
                        break;
                    $this->catalogPages[(int) $page->id] = new RecyclerLayout($page);
                    break;
                case CatalogPageLayouts::recycler_info:
                    if (!Emulator::getConfig()->getBoolean("hotel.ecotron.enabled"))
                        break;
                    $this->catalogPages[(int) $page->id] = new RecyclerInfoLayout($page);
                    break;
                case CatalogPageLayouts::recycler_prizes:
                    if (!Emulator::getConfig()->getBoolean("hotel.ecotron.enabled"))
                        break;
                    $this->catalogPages[(int) $page->id] = new RecyclerPrizesLayout($page);
                    break;
                case CatalogPageLayouts::marketplace:
                    if (!Emulator::getConfig()->getBoolean("hotel.marketplace.enabled"))
                        break;
                    $this->catalogPages[(int) $page->id] = new MarketplaceLayout($page);
                    break;
                case CatalogPageLayouts::marketplace_own_items:
                    if (!Emulator::getConfig()->getBoolean("hotel.marketplace.enabled"))
                        break;
                    $this->catalogPages[(int) $page->id] = new MarketplaceOwnItems($page);
                    break;
                case CatalogPageLayouts::info_duckets:
                    $this->catalogPages[(int) $page->id] = new InfoDucketsLayout($page);
                    break;
                case CatalogPageLayouts::info_pets:
                    $this->catalogPages[(int) $page->id] = new InfoPetsLayout($page);
                    break;
                case CatalogPageLayouts::info_rentables:
                    $this->catalogPages[(int) $page->id] = new InfoRentablesLayout($page);
                    break;
                case CatalogPageLayouts::guilds:
                    $this->catalogPages[(int) $page->id] = new GuildFrontpageLayout($page);
                    break;
                case CatalogPageLayouts::guild_furni:
                    $this->catalogPages[(int) $page->id] = new GuildFurnitureLayout($page);
                    break;
                case CatalogPageLayouts::pets:
                    $this->catalogPages[(int) $page->id] = new PetsLayout($page);
                    break;
                case CatalogPageLayouts::pets2:
                    $this->catalogPages[(int) $page->id] = new Pets2Layout($page);
                    break;
                case CatalogPageLayouts::pets3:
                    $this->catalogPages[(int) $page->id] = new Pets3Layout($page);
                    break;
                case CatalogPageLayouts::productpage1:
                    $this->catalogPages[(int) $page->id] = new ProductPage1Layout($page);
                    break;
                case CatalogPageLayouts::soundmachine:
                    $this->catalogPages[(int) $page->id] = new TraxLayout($page);
                    break;
                case CatalogPageLayouts::default_3x3_color_grouping:
                    $this->catalogPages[(int) $page->id] = new ColorGroupingLayout($page);
                    break;
                case CatalogPageLayouts::recent_purchases:
                    $this->catalogPages[(int) $page->id] = new RecentPurchasesLayout($page);
                    break;
                case CatalogPageLayouts::room_bundle:
                    //$this->catalogPages[(int) $page->id] = new RoomBundleLayout($page);
                    break;
                case CatalogPageLayouts::petcustomization:
                    $this->catalogPages[(int) $page->id] = new PetCustomizationLayout($page);
                    break;
            }
        }
    }

    private function loadCatalogItems() {
        unset($this->clubItems);
        $this->clubItems = array();
        CatalogManager::$catalogItemCount = 0;
        $query = Emulator::getDatabase()->query("SELECT * FROM catalog_items;");

        foreach ($query as $item) {
            if ($item->item_ids == "1") {
                continue;
            }

            if (strpos($item->catalog_name, "HABBO_CLUB_") !== false) {
                $this->clubItems[] = new CatalogItem($item);
            }

            if (!isset($this->catalogPages[(int) $item->page_id])) {
                continue;
            }

            $page = $this->catalogPages[(int) $item->page_id];
            $itemx = $page->getCatalogItem((int) $item->id);

            if ($itemx == null) {
                CatalogManager::$catalogItemCount++;
                $itemx = new CatalogItem($item);
                $page->addItem($itemx);
                if ($itemx->getOfferId() == -1) {
                    continue;
                }
                $page->addOfferId($itemx->getOfferId());
                $this->offerDefs[$itemx->getOfferId()] = $page->getId();
                continue;
            }
            $itemx->update($item);
        }
    }

    private function loadVouchers() {
        unset($this->vouchers);
        $this->vouchers = array();
        $query = Emulator::getDatabase()->query("SELECT * FROM vouchers;");

        foreach ($query as $voucher) {
            $this->vouchers[] = new Voucher($voucher);
        }
    }

}
