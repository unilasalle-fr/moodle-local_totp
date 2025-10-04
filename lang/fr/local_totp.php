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
 * Chaînes de langue françaises pour local_totp
 *
 * @package   local_totp
 * @copyright 2025, Loïc CRAMPON <loic.crampon@gmail.com>
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

$string['pluginname'] = 'TOTP Enseignant (Mot de passe à usage unique temporel)';
$string['title'] = 'TOTP Enseignant';
$string['description'] = 'Un outil enseignant pour afficher des codes TOTP aux étudiants.';
$string['totp'] = 'Code TOTP';

// Settings.
$string['setting_secretphrase'] = 'Phrase secrète';
$string['setting_secretphrase_desc'] = 'Phrase secrète utilisée pour chiffrer les codes TOTP (minimum 64 caractères)';
$string['setting_totplength'] = 'Longueur du code TOTP';
$string['setting_totplength_desc'] = 'Nombre de chiffres dans les codes TOTP (par défaut : 6)';
$string['setting_totpvalidity'] = 'Durée de validité du TOTP';
$string['setting_totpvalidity_desc'] = 'Durée en secondes pendant laquelle un code TOTP reste valide (par défaut : 30)';

// View page.
$string['secondsremaining'] = 'secondes restantes';
$string['totpinfo'] = 'Ce code TOTP est unique à ce cours et se renouvelle automatiquement à la fin de sa période de validité.';
$string['openpopup'] = 'Ouvrir dans une fenêtre popup';

// Capabilities.
$string['totp:view'] = 'Voir le code TOTP du cours';

// Errors.
$string['secretphrasenotset'] = 'La phrase secrète n\'est pas configurée. Veuillez contacter l\'administrateur du site.';
