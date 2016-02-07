<?php

namespace Emulator\HabboHotel\Catalog;

use Thread;

class CatalogItem extends Thread {

    protected $id;
    protected $pageId;
    protected $itemId;
    protected $name;
    protected $credits;
    protected $points;
    protected $pointsType;
    protected $amount;
    protected $limitedStack;
    protected $limitedSells;
    protected $extradata;
    protected $badge;
    protected $clubOnly;
    protected $haveOffer;
    protected $offerId;
    protected $needsUpdate;
    protected $hasBadge;
    protected $bundle;

    public function __construct($set) {
        $this->load($set);
        $this->needsUpdate = false;
    }

    public function update($set) {
        $this->load($set);
    }

    private function load($set) {
        $this->id = (int) $set->id;
        $this->pageId = (int) $set->page_id;
        $this->itemId = $set->item_ids;
        $this->name = $set->catalog_name;
        $this->credits = (int) $set->cost_credits;
        $this->points = (int) $set->cost_points;
        $this->pointsType = (int) $set->points_type;
        $this->amount = (int) $set->amount;
        $this->limitedStack = (int) $set->limited_stack;
        $this->limitedSells = (int) $set->limited_sells;
        $this->extradata = $set->extradata;
        $this->badge = $set->badge;
        $this->clubOnly = (bool) $set->club_only == 1;
        $this->haveOffer = (bool) $set->have_offer == 1;
        $this->offerId = (int) $set->offer_id;
        $this->bundle = array();
        //$this->loadBundle();
        $this->hasBadge = strlen($this->badge) > 0;
    }

    public function getId() {
        return $this->id;
    }

    public function getPageId() {
        return $this->pageId;
    }

    public function getItemId() {
        return $this->itemId;
    }

    public function getName() {
        return $this->name;
    }

    public function getCredits() {
        return $this->credits;
    }

    public function getPoints() {
        return $this->points;
    }

    public function getPointsType() {
        return $this->pointsType;
    }

    public function getAmount() {
        return $this->amount;
    }

    public function getLimitedStack() {
        return $this->limitedStack;
    }

    public function getLimitedSells() {
        return $this->limitedSells;
    }

    public function getExtradata() {
        return $this->extradata;
    }

    public function getBadge() {
        return $this->badge;
    }

    public function isClubOnly() {
        return $this->clubOnly;
    }

    public function isHaveOffer() {
        return $this->haveOffer;
    }

    public function isLimited() {
        return $this->limitedStack > 0;
    }

    public function getOfferId() {
        return $this->offerId;
    }

    public function getHasBadge() {
        return $this->hasBadge;
    }

    public function getBundle() {
        return $this->bundle;
    }

}
