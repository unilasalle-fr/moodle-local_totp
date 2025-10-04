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
 * Language strings for local_totp
 *
 * @package   local_totp
 * @copyright 2025, Loïc CRAMPON <loic.crampon@gmail.com>
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

$string['pluginname'] = 'TOTP Teacher (Time-based One-Time Password)';
$string['title'] = 'TOTP Teacher';
$string['description'] = 'A teacher tool to display TOTP codes for students.';
$string['totp'] = 'TOTP Code';

// Settings.
$string['setting_secretphrase'] = 'Secret phrase';
$string['setting_secretphrase_desc'] = 'Secret phrase used to encrypt TOTP codes (minimum 64 characters)';
$string['setting_totplength'] = 'TOTP code length';
$string['setting_totplength_desc'] = 'Number of digits in TOTP codes (default: 6)';
$string['setting_totpvalidity'] = 'TOTP validity duration';
$string['setting_totpvalidity_desc'] = 'Duration in seconds for which a TOTP code remains valid (default: 30)';

// View page.
$string['secondsremaining'] = 'seconds remaining';
$string['totpinfo'] = 'This TOTP code is unique to this course and automatically refreshes at the end of its validity period.';
$string['openpopup'] = 'Open in popup window';

// Capabilities.
$string['totp:view'] = 'View course TOTP code';

// Errors.
$string['secretphrasenotset'] = 'Secret phrase is not configured. Please contact your site administrator.';
