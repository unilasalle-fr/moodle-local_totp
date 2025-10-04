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
 * TOTP display page
 *
 * @package   local_totp
 * @copyright 2025, Loïc CRAMPON <loic.crampon@gmail.com>
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require_once(__DIR__ . '/../../config.php');

// Get course ID parameter.
$courseid = required_param('courseid', PARAM_INT);

// Get course and context.
$course = get_course($courseid);
$context = context_course::instance($courseid);

// Check login and permissions.
require_login($course);
require_capability('local/totp:view', $context);

// Set up page.
$PAGE->set_url('/local/totp/view.php', ['courseid' => $courseid]);
$PAGE->set_context($context);
$PAGE->set_course($course);
$PAGE->set_pagelayout('incourse');
$PAGE->set_title(get_string('totp', 'local_totp'));
$PAGE->set_heading($course->fullname);

// Get plugin settings.
$secretphrase = get_config('local_totp', 'secretphrase');
$totplength = get_config('local_totp', 'totplength') ?: 6;
$totpvalidity = get_config('local_totp', 'totpvalidity') ?: 30;

// Check if secret phrase is configured.
if (empty($secretphrase)) {
    throw new moodle_exception('secretphrasenotset', 'local_totp');
}

// Generate TOTP.
$totp = \local_totp\totp_generator::generate($secretphrase, $courseid, null, $totplength, $totpvalidity);
$remaining = \local_totp\totp_generator::get_remaining_seconds(null, $totpvalidity);

// Prepare output.
$output = $PAGE->get_renderer('local_totp');
$page = new \local_totp\output\view_page($totp, $remaining, $totpvalidity, $courseid);

// Output page.
echo $output->header();
echo $output->render($page);
echo $output->footer();
