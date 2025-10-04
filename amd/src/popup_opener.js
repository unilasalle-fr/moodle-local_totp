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
 * TOTP popup opener module
 *
 * @module     local_totp/popup_opener
 * @copyright  2025, Loïc CRAMPON <loic.crampon@gmail.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

define(['jquery'], function($) {
    'use strict';

    /**
     * Initialize the popup opener
     */
    var init = function() {
        // Listen for clicks on popup button.
        $(document).on('click', '[data-action="open-popup"]', function(e) {
            e.preventDefault();

            var courseid = $(this).data('courseid');
            var url = M.cfg.wwwroot + '/local/totp/popup.php?courseid=' + courseid;

            // Calculate popup window size (80% of screen, max 800px).
            var width = Math.min(800, window.screen.width * 0.8);
            var height = Math.min(800, window.screen.height * 0.8);
            var left = (window.screen.width - width) / 2;
            var top = (window.screen.height - height) / 2;

            // Open popup window (not a new tab).
            window.open(
                url,
                'totp_popup_' + courseid,
                'width=' + width +
                ',height=' + height +
                ',left=' + left +
                ',top=' + top +
                ',resizable=yes' +
                ',scrollbars=no' +
                ',toolbar=no' +
                ',menubar=no' +
                ',location=no' +
                ',status=no'
            );
        });
    };

    return {
        init: init
    };
});
