<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * Renderable class for TOTP popup page
 *
 * @package   local_totp
 * @copyright 2025, Loïc CRAMPON <loic.crampon@gmail.com>
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace local_totp\output;

defined('MOODLE_INTERNAL') || die();

use renderable;
use renderer_base;
use templatable;
use stdClass;

/**
 * Popup page renderable class
 */
class popup_page implements renderable, templatable {
    /** @var string TOTP code */
    protected $totp;

    /** @var int Remaining seconds */
    protected $remaining;

    /** @var int Validity period */
    protected $period;

    /** @var int Course ID */
    protected $courseid;

    /**
     * Constructor
     *
     * @param string $totp TOTP code
     * @param int $remaining Remaining seconds
     * @param int $period Validity period in seconds
     * @param int $courseid Course ID
     */
    public function __construct($totp, $remaining, $period, $courseid) {
        $this->totp = $totp;
        $this->remaining = $remaining;
        $this->period = $period;
        $this->courseid = $courseid;
    }

    /**
     * Export data for template
     *
     * @param renderer_base $output
     * @return stdClass
     */
    public function export_for_template(renderer_base $output) {
        $data = new stdClass();
        $data->totp = $this->totp;
        $data->remaining = $this->remaining;
        $data->period = $this->period;
        $data->courseid = $this->courseid;

        // Calculate SVG circle properties (radius = 110px).
        $data->circumference = round(2 * M_PI * 110);
        $fraction = $this->remaining / $this->period;
        $data->dashoffset = round($data->circumference - ($fraction * $data->circumference));

        return $data;
    }
}
