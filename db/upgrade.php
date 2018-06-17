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
 * This file keeps track of upgrades to the character module
 *
 * Sometimes, changes between versions involve alterations to database
 * structures and other major things that may break installations. The upgrade
 * function in this file will attempt to perform all the necessary actions to
 * upgrade your older installation to the current version. If there's something
 * it cannot do itself, it will tell you what you need to do.  The commands in
 * here will all be database-neutral, using the functions defined in DLL libraries.
 *
 * @package    mod_character
 * @copyright  2016 Your Name <contact@alfasz.me>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

/**
 * Execute character upgrade from the given old version
 *
 * @param int $oldversion
 * @return bool
 */
function xmldb_character_upgrade($oldversion) {
    global $DB;

    $dbman = $DB->get_manager(); // Loads ddl manager and xmldb classes.


    if ($oldversion < 2007040100) {

        // Define field course to be added to character.
        $table = new xmldb_table('character');
        $field = new xmldb_field('course', XMLDB_TYPE_INTEGER, '10', XMLDB_UNSIGNED, XMLDB_NOTNULL, null, '0', 'id');

        // Add field course.
        if (!$dbman->field_exists($table, $field)) {
            $dbman->add_field($table, $field);
        }

        // Define field intro to be added to character.
        $table = new xmldb_table('character');
        $field = new xmldb_field('intro', XMLDB_TYPE_TEXT, 'medium', null, null, null, null, 'name');

        // Add field intro.
        if (!$dbman->field_exists($table, $field)) {
            $dbman->add_field($table, $field);
        }

        // Define field introformat to be added to character.
        $table = new xmldb_table('character');
        $field = new xmldb_field('introformat', XMLDB_TYPE_INTEGER, '4', XMLDB_UNSIGNED, XMLDB_NOTNULL, null, '0',
            'intro');

        // Add field introformat.
        if (!$dbman->field_exists($table, $field)) {
            $dbman->add_field($table, $field);
        }

        // Define field timecreated to be added to character.
        $table = new xmldb_table('character');
        $field = new xmldb_field('timecreated', XMLDB_TYPE_INTEGER, '10', XMLDB_UNSIGNED, XMLDB_NOTNULL, null, '0',
            'introformat');

        // Add field timecreated.
        if (!$dbman->field_exists($table, $field)) {
            $dbman->add_field($table, $field);
        }

        // Define field timemodified to be added to character.
        $table = new xmldb_table('character');
        $field = new xmldb_field('timemodified', XMLDB_TYPE_INTEGER, '10', XMLDB_UNSIGNED, XMLDB_NOTNULL, null, '0',
            'timecreated');

        // Add field timemodified.
        if (!$dbman->field_exists($table, $field)) {
            $dbman->add_field($table, $field);
        }

        // Define index course (not unique) to be added to character.
        $table = new xmldb_table('character');
        $index = new xmldb_index('courseindex', XMLDB_INDEX_NOTUNIQUE, array('course'));

        // Add index to course field.
        if (!$dbman->index_exists($table, $index)) {
            $dbman->add_index($table, $index);
        }


        // Define table character_sprite to be created.
        $table = new xmldb_table('character_sprite');

        // Adding fields to table character_sprite.
        $table->add_field('id', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, XMLDB_SEQUENCE, null);
        $table->add_field('userid', XMLDB_TYPE_INTEGER, '20', null, null, null, null);
        $table->add_field('username', XMLDB_TYPE_CHAR, '100', null, XMLDB_NOTNULL, null, null);
        $table->add_field('background', XMLDB_TYPE_INTEGER, '3', null, XMLDB_NOTNULL, null, null);
        $table->add_field('skin', XMLDB_TYPE_INTEGER, '3', null, XMLDB_NOTNULL, null, null);
        $table->add_field('hair', XMLDB_TYPE_INTEGER, '3', null, XMLDB_NOTNULL, null, null);
        $table->add_field('eyes', XMLDB_TYPE_INTEGER, '3', null, XMLDB_NOTNULL, null, null);
        $table->add_field('mouth', XMLDB_TYPE_INTEGER, '3', null, XMLDB_NOTNULL, null, null);
        $table->add_field('body', XMLDB_TYPE_INTEGER, '3', null, XMLDB_NOTNULL, null, null);
        $table->add_field('legs', XMLDB_TYPE_INTEGER, '3', null, XMLDB_NOTNULL, null, null);
        $table->add_field('shoes', XMLDB_TYPE_INTEGER, '3', null, XMLDB_NOTNULL, null, null);
        $table->add_field('complements', XMLDB_TYPE_INTEGER, '3', null, XMLDB_NOTNULL, null, null);

        // Adding keys to table character_sprite.
        $table->add_key('primary', XMLDB_KEY_PRIMARY, array('id'));
        $table->add_key('userid', XMLDB_KEY_UNIQUE, array('userid'));

        // Conditionally launch create table for character_sprite.
        if (!$dbman->table_exists($table)) {
            $dbman->create_table($table);
        }

        // Define table character_skills to be created.
        $table = new xmldb_table('character_skills');

        // Adding fields to table character_skills.
        $table->add_field('id', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, XMLDB_SEQUENCE, null);
        $table->add_field('userid', XMLDB_TYPE_INTEGER, '3', null, XMLDB_NOTNULL, null, null);
        $table->add_field('skill1', XMLDB_TYPE_INTEGER, '2', null, XMLDB_NOTNULL, null, '0');
        $table->add_field('skill2', XMLDB_TYPE_INTEGER, '2', null, XMLDB_NOTNULL, null, '0');
        $table->add_field('skill3', XMLDB_TYPE_INTEGER, '2', null, XMLDB_NOTNULL, null, '0');
        $table->add_field('skill4', XMLDB_TYPE_INTEGER, '3', null, XMLDB_NOTNULL, null, '0');
        $table->add_field('skill5', XMLDB_TYPE_INTEGER, '2', null, XMLDB_NOTNULL, null, '0');
        $table->add_field('skill6', XMLDB_TYPE_INTEGER, '3', null, XMLDB_NOTNULL, null, '0');
        $table->add_field('skill7', XMLDB_TYPE_INTEGER, '2', null, XMLDB_NOTNULL, null, '0');
        $table->add_field('skill8', XMLDB_TYPE_INTEGER, '2', null, XMLDB_NOTNULL, null, '0');

        // Adding keys to table character_skills.
        $table->add_key('primary', XMLDB_KEY_PRIMARY, array('id'));
        $table->add_key('userid', XMLDB_KEY_UNIQUE, array('userid'));

        // Conditionally launch create table for character_skills.
        if (!$dbman->table_exists($table)) {
            $dbman->create_table($table);
        }

        // Character savepoint reached.
        upgrade_mod_savepoint(true, 2018050403, 'character');
    }

    return true;
}
