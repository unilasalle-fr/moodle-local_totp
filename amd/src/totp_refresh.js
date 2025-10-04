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
 * TOTP auto-refresh JavaScript module
 *
 * @module     local_totp/totp_refresh
 * @copyright  2025, Loïc CRAMPON <loic.crampon@gmail.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

define(['jquery', 'core/ajax'], function($, Ajax) {
    'use strict';

    var courseId = 0;
    var period = 30;
    var circumference = 691;
    var remainingSeconds = 0;

    /**
     * Update the TOTP display
     */
    var updateTotp = function() {
        var promises = Ajax.call([{
            methodname: 'local_totp_get_totp',
            args: {courseid: courseId}
        }]);

        promises[0].done(function(response) {
            $('#totp-code').text(response.totp);
            remainingSeconds = response.remaining;
            $('#totp-remaining').text(remainingSeconds);

            // Reset progress to 100% instantly (no transition) for new TOTP.
            var $circle = $('#totp-progress-circle');
            $circle.css('transition', 'none');
            $circle.css('stroke-dashoffset', 0);

            // Re-enable transition after a short delay.
            setTimeout(function() {
                $circle.css('transition', 'stroke-dashoffset 1s linear');
            }, 50);
        }).fail(function(ex) {
            // eslint-disable-next-line no-console
            console.error('Failed to refresh TOTP:', ex);
        });
    };

    /**
     * Update the circular progress bar
     */
    var updateProgress = function() {
        var fraction = remainingSeconds / period;
        var offset = circumference - (fraction * circumference);
        $('#totp-progress-circle').css('stroke-dashoffset', offset);
    };

    /**
     * Countdown timer
     */
    var countdown = function() {
        remainingSeconds--;
        if (remainingSeconds < 0) {
            remainingSeconds = period;
            updateTotp();
        } else {
            $('#totp-remaining').text(remainingSeconds);
            updateProgress();
        }
    };

    /**
     * Initialize the TOTP refresh module
     *
     * @param {number} cid Course ID
     * @param {number} p Period in seconds
     * @param {number} circ Circle circumference
     */
    var init = function(cid, p, circ) {
        courseId = cid;
        period = p;
        circumference = circ;
        remainingSeconds = parseInt($('#totp-remaining').text());

        // Update countdown every second.
        setInterval(countdown, 1000);
    };

    return {
        init: init
    };
});
