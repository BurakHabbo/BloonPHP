<?php

namespace Emulator\Util;

use COM;

class System {

    public static function getPhysicalMemory() {
        if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
            $wmi = new COM('WinMgmts:root/cimv2');
            $res = $wmi->ExecQuery('Select TotalPhysicalMemory from Win32_ComputerSystem');
            $system = $res->ItemIndex(0);
            return round((int) $system->TotalPhysicalMemory / 1024 / 1024 / 1024, 1);
        } else {
            $data = explode("\n", file_get_contents("/proc/meminfo"));
            foreach ($data as $line) {
                list($key, $val) = explode(":", $line);
                if ($key == "MemTotal") {
                    return round((int) explode(" ", trim($val))[0] / 1024 / 1024, 1);
                }
            }
            return 0;
        }
    }

    public static function getMaxMemory() {
        $val = trim(ini_get('memory_limit'));
        $last = strtolower($val[strlen($val) - 1]);
        $val = (int) $val;

        switch ($last) {
            case 'g':
                break;
            case 'm':
                $val /= 1024;
                break;
            case 'k':
                $val /= 1024 / 1024;
                break;
        }
        return round($val, 1);
    }

    public static function getAvailableProcessors() {
        $numCpus = 1;
        if (is_file('/proc/cpuinfo')) {
            $cpuinfo = file_get_contents('/proc/cpuinfo');
            preg_match_all('/^processor/m', $cpuinfo, $matches);
            $numCpus = count($matches[0]);
        } else if ('WIN' == strtoupper(substr(PHP_OS, 0, 3))) {
            $process = @popen('wmic cpu get NumberOfCores', 'rb');
            if (false !== $process) {
                fgets($process);
                $numCpus = intval(fgets($process));
                pclose($process);
            }
        } else {
            $process = @popen('sysctl -a', 'rb');
            if (false !== $process) {
                $output = stream_get_contents($process);
                preg_match('/hw.ncpu: (\d+)/', $output, $matches);
                if ($matches) {
                    $numCpus = intval($matches[1][0]);
                }
                pclose($process);
            }
        }

        return $numCpus;
    }

}
