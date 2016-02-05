<?php

namespace Emulator\HabboHotel\HotelView;

class NewsWidget {

    private $id;
    private $title;
    private $message;
    private $buttonMessage;
    private $type;
    private $link;
    private $image;

    public function __construct($set) {
        $this->id = $set->id;
        $this->title = $set->title;
        $this->message = $set->text;
        $this->buttonMessage = $set->button_text;
        $this->type = ($set->button_text == "client" ? 1 : 0);
        $this->link = $set->button_link;
        $this->image = $set->image;
    }

    public function getId() {
        return $this->id;
    }

    public function getTitle() {
        return $this->title;
    }

    public function getMessage() {
        return $this->message;
    }

    public function getButtonMessage() {
        return $this->buttonMessage;
    }

    public function getType() {
        return $this->type;
    }

    public function getLink() {
        return $this->link;
    }

    public function getImage() {
        return $this->image;
    }

}
