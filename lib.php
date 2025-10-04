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
 * Library functions for local_totp
 *
 * @package   local_totp
 * @copyright 2025, Loïc CRAMPON <loic.crampon@gmail.com>
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

/**
 * Extend course navigation to add TOTP link
 *
 * @param navigation_node $parentnode The parent navigation node
 * @param stdClass $course The course object
 * @param context_course $context The course context
 */
function local_totp_extend_navigation_course(navigation_node $parentnode, stdClass $course, context_course $context) {
    // Don't add to site course.
    if ($course->id == SITEID) {
        return;
    }

    // Check if user has capability to view TOTP.
    if (!has_capability('local/totp:view', $context)) {
        return;
    }

    // Add TOTP link to course navigation.
    $parentnode->add(
        get_string('totp', 'local_totp'),
        new moodle_url('/local/totp/view.php', ['courseid' => $course->id]),
        navigation_node::TYPE_SETTING,
        null,
        'local_totp',
        new pix_icon('i/lock', '', 'core')
    );
}