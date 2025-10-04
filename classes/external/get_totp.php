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
 * External API for getting TOTP code
 *
 * @package   local_totp
 * @copyright 2025, Loïc CRAMPON <loic.crampon@gmail.com>
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace local_totp\external;

defined('MOODLE_INTERNAL') || die();

require_once($CFG->libdir . '/externallib.php');

use external_api;
use external_function_parameters;
use external_value;
use external_single_structure;
use context_course;

/**
 * External API class for getting TOTP
 */
class get_totp extends external_api {
    /**
     * Returns description of method parameters
     *
     * @return external_function_parameters
     */
    public static function execute_parameters() {
        return new external_function_parameters([
            'courseid' => new external_value(PARAM_INT, 'Course ID'),
        ]);
    }

    /**
     * Get TOTP code for a course
     *
     * @param int $courseid Course ID
     * @return array TOTP data
     */
    public static function execute($courseid) {
        global $USER;

        // Validate parameters.
        $params = self::validate_parameters(self::execute_parameters(), [
            'courseid' => $courseid,
        ]);

        // Validate context and check capability.
        $context = context_course::instance($params['courseid']);
        self::validate_context($context);
        require_capability('local/totp:view', $context);

        // Get plugin settings.
        $secretphrase = get_config('local_totp', 'secretphrase');
        $totplength = get_config('local_totp', 'totplength') ?: 6;
        $totpvalidity = get_config('local_totp', 'totpvalidity') ?: 30;

        // Generate TOTP.
        $totp = \local_totp\totp_generator::generate($secretphrase, $params['courseid'], null, $totplength, $totpvalidity);
        $remaining = \local_totp\totp_generator::get_remaining_seconds(null, $totpvalidity);

        return [
            'totp' => $totp,
            'remaining' => $remaining,
            'period' => $totpvalidity,
        ];
    }

    /**
     * Returns description of method result value
     *
     * @return external_single_structure
     */
    public static function execute_returns() {
        return new external_single_structure([
            'totp' => new external_value(PARAM_TEXT, 'TOTP code'),
            'remaining' => new external_value(PARAM_INT, 'Remaining seconds'),
            'period' => new external_value(PARAM_INT, 'Validity period'),
        ]);
    }
}
