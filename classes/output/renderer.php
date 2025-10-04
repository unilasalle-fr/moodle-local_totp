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
 * Renderer for local_totp
 *
 * @package   local_totp
 * @copyright 2025, Loïc CRAMPON <loic.crampon@gmail.com>
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace local_totp\output;

defined('MOODLE_INTERNAL') || die();

use plugin_renderer_base;

/**
 * Renderer class for local_totp
 */
class renderer extends plugin_renderer_base {
    /**
     * Render the view page
     *
     * @param view_page $page
     * @return string HTML
     */
    protected function render_view_page(view_page $page) {
        $data = $page->export_for_template($this);
        return $this->render_from_template('local_totp/view_page', $data);
    }
}
