<?php

namespace Emulator\HabboHotel\Catalog;

use Emulator\Messages\ServerMessage;
use Emulator\HabboHotel\Catalog\CatalogItem;

abstract class CatalogPage {

    private $id;
    private $parentId;
    private $rank;
    private $caption;
    private $pageName;
    private $iconColor;
    private $iconImage;
    private $orderNum;
    private $visible;
    private $enabled;
    private $clubOnly;
    private $layout;
    private $headerImage;
    private $teaserImage;
    private $specialImage;
    private $textOne;
    private $textTwo;
    private $textDetails;
    private $textTeaser;
    private $offerIds;
    private $catalogItems;

    public function __construct($set) {
        $this->id = (int) $set->id;
        $this->parentId = (int) $set->parent_id;
        $this->rank = (int) $set->min_rank;
        $this->caption = $set->caption;
        $this->pageName = $set->caption_save;
        $this->iconColor = (int) $set->icon_color;
        $this->iconImage = (int) $set->icon_image;
        $this->orderNum = (int) $set->order_num;
        $this->visible = (bool) $set->visible == 1;
        $this->enabled = (bool) $set->enabled == 1;
        $this->clubOnly = (bool) $set->club_only == 1;
        $this->layout = $set->page_layout;
        $this->headerImage = $set->page_headline;
        $this->teaserImage = $set->page_teaser;
        $this->specialImage = $set->page_special;
        $this->textOne = $set->page_text1;
        $this->textTwo = $set->page_text2;
        $this->textDetails = $set->page_text_details;
        $this->textTeaser = $set->page_text_teaser;
        $this->offerIds = array();
        $this->catalogItems = array();
    }

    public function addOfferId(int $id) {
        $this->offerIds[] = $id;
    }

    public function addItem(CatalogItem $item) {
        $this->catalogItems[$item->getId()] = $item;
    }

    public function getId() {
        return $this->id;
    }

    public function getParentId() {
        return $this->parentId;
    }

    public function getRank() {
        return $this->rank;
    }

    public function getCaption() {
        return $this->caption;
    }

    public function getPageName() {
        return $this->pageName;
    }

    public function getIconColor() {
        return $this->iconColor;
    }

    public function getIconImage() {
        return $this->iconImage;
    }

    public function getOrderNum() {
        return $this->orderNum;
    }

    public function isVisible() {
        return $this->visible;
    }

    public function isEnabled() {
        return $this->enabled;
    }

    public function isClubOnly() {
        return $this->clubOnly;
    }

    public function getLayout() {
        return $this->layout;
    }

    public function getHeaderImage() {
        return $this->headerImage;
    }

    public function getTeaserImage() {
        return $this->teaserImage;
    }

    public function getSpecialImage() {
        return $this->specialImage;
    }

    public function getTextOne() {
        return $this->textOne;
    }

    public function getTextTwo() {
        return $this->textTwo;
    }

    public function getTextDetails() {
        return $this->textDetails;
    }

    public function getTextTeaser() {
        return $this->textTeaser;
    }

    public function getOfferIds() {
        return $this->offerIds;
    }

    public function getCatalogItems() {
        return $this->catalogItems;
    }

    public function getCatalogItem(int $id) {
        return isset($this->catalogItems[$id]) ? $this->catalogItems[$id] : null;
    }

    abstract protected function serialize(ServerMessage $message);
}
