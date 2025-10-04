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
 * TOTP generator class implementing RFC 6238
 *
 * @package   local_totp
 * @copyright 2025, Loïc CRAMPON <loic.crampon@gmail.com>
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace local_totp;

defined('MOODLE_INTERNAL') || die();

/**
 * TOTP generator class
 */
class totp_generator {
    /**
     * Generate a TOTP code based on RFC 6238
     *
     * @param string $secretphrase Secret phrase from plugin settings
     * @param int $courseid Course ID to combine with secret
     * @param int|null $time Current timestamp (null = current time)
     * @param int $digits Number of digits in TOTP code (default 6)
     * @param int $period Validity period in seconds (default 30)
     * @return string TOTP code padded with leading zeros
     */
    public static function generate($secretphrase, $courseid, $time = null, $digits = 6, $period = 30) {
        // Use current time if not provided.
        if ($time === null) {
            $time = time();
        }

        // Create the secret key by combining secret phrase and course ID.
        $key = $secretphrase . ':' . $courseid;

        // Calculate time step (RFC 6238).
        $timestep = floor($time / $period);

        // Pack time step into binary string (8 bytes, big-endian).
        $data = pack('J', $timestep);

        // Generate HMAC-SHA256 hash.
        $hash = hash_hmac('sha256', $data, $key, true);

        // Dynamic truncation (RFC 6238 section 5.3).
        $offset = ord(substr($hash, -1)) & 0x0F;
        $truncated = unpack('N', substr($hash, $offset, 4))[1];
        $truncated &= 0x7FFFFFFF;

        // Generate N-digit code.
        $code = $truncated % pow(10, $digits);

        // Pad with leading zeros.
        return str_pad($code, $digits, '0', STR_PAD_LEFT);
    }

    /**
     * Get remaining seconds until next TOTP refresh
     *
     * @param int|null $time Current timestamp (null = current time)
     * @param int $period Validity period in seconds
     * @return int Seconds remaining in current period
     */
    public static function get_remaining_seconds($time = null, $period = 30) {
        if ($time === null) {
            $time = time();
        }
        return $period - ($time % $period);
    }

    /**
     * Validate a TOTP code for a given course
     *
     * @param string $code TOTP code to validate
     * @param int $courseid Course ID
     * @param int $window Time window tolerance (number of periods before/after, default 1)
     * @return bool True if code is valid, false otherwise
     */
    public static function validate($code, $courseid, $window = 1) {
        // Get plugin settings.
        $secretphrase = get_config('local_totp', 'secretphrase');
        $totplength = get_config('local_totp', 'totplength') ?: 6;
        $totpvalidity = get_config('local_totp', 'totpvalidity') ?: 30;

        // Check if secret phrase is configured.
        if (empty($secretphrase)) {
            return false;
        }

        // Normalize code (remove spaces, ensure correct length).
        $code = preg_replace('/\s+/', '', $code);
        if (strlen($code) != $totplength) {
            return false;
        }

        $currenttime = time();

        // Check current period and adjacent periods (for clock skew tolerance).
        for ($i = -$window; $i <= $window; $i++) {
            $testtime = $currenttime + ($i * $totpvalidity);
            $expectedcode = self::generate($secretphrase, $courseid, $testtime, $totplength, $totpvalidity);

            if ($code === $expectedcode) {
                return true;
            }
        }

        return false;
    }

    /**
     * Check if TOTP is properly configured
     *
     * @return bool True if secret phrase is configured, false otherwise
     */
    public static function is_configured() {
        $secretphrase = get_config('local_totp', 'secretphrase');
        return !empty($secretphrase);
    }
}
