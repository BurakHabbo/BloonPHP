<?php

namespace Emulator\HabboHotel\Permissions;

use Emulator\Util\StringUtil;
use Emulator\Emulator;
use Ubench;

class PermissionsManager {

    private $permissions;
    private $rankNames;
    private $enables;

    public function __construct() {
        $bench = new Ubench();
        $bench->start();

        $this->permissions = array();
        $this->rankNames = array();
        $this->enables = array();
        $this->reload();

        $bench->end();
        Emulator::getLogging()->logStart("Permissions Manager -> Loaded! (" . $bench->getTime() . ")");
    }

    public function reload() {
        $this->loadPermissions();
        $this->loadEnables();
    }

    private function loadPermissions() {
        unset($this->permissions);
        $this->permissions = array();

        $query = Emulator::getDatabase()->query("SELECT * FROM permissions ORDER BY id ASC;");
        $columns = array_keys(get_object_vars($query[0]));

        foreach ($query as $permission) {
            $names = array();
            foreach ($columns as $column) {
                if (StringUtil::startsWith($column, "cmd_") || StringUtil::startsWith($column, "acc_")) {
                    if ($permission->$column != "1") {
                        continue;
                    }
                    $names[] = $column;
                    continue;
                }
                if ($column != "rank_name")
                    continue;
                $this->rankNames[(int) $permission->id] = $permission->$column;
            }
            $this->permissions[(int) $permission->id] = $names;
        }
    }

    private function loadEnables() {
        unset($this->enables);
        $this->enables = array();

        $query = Emulator::getDatabase()->query("SELECT * FROM special_enables;");

        foreach ($query as $enable) {
            $this->enables[(int) $enable->effect_id] = (int) $enable->min_rank;
        }
    }

}
