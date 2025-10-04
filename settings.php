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
 * Plugin settings
 *
 * @package   local_totp
 * @copyright 2025, Loïc CRAMPON <loic.crampon@gmail.com>
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

if ($hassiteconfig) {
    $settings = new admin_settingpage('local_totp', get_string('pluginname', 'local_totp'));
    $ADMIN->add('localplugins', $settings);

    if ($ADMIN->fulltree) {
    // Secret phrase setting
    $settings->add(new admin_setting_configpasswordunmask('local_totp/secretphrase',
        new lang_string('setting_secretphrase', 'local_totp'),
        new lang_string('setting_secretphrase_desc', 'local_totp'),
        '', PARAM_TEXT));

    // TOTP code length setting
    $settings->add(new admin_setting_configselect('local_totp/totplength',
        new lang_string('setting_totplength', 'local_totp'),
        new lang_string('setting_totplength_desc', 'local_totp'),
        6,
        array(
            4 => '4',
            5 => '5',
            6 => '6',
            7 => '7',
            8 => '8'
        )));

    // TOTP validity duration setting
    $settings->add(new admin_setting_configselect('local_totp/totpvalidity',
        new lang_string('setting_totpvalidity', 'local_totp'),
        new lang_string('setting_totpvalidity_desc', 'local_totp'),
        30,
        array(
            10 => '10 seconds',
            15 => '15 seconds',
            30 => '30 seconds',
            45 => '45 seconds',
            60 => '60 seconds',
            90 => '90 seconds',
            120 => '2 minutes'
        )));
    }
}