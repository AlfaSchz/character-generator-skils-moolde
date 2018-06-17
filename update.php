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
 * Prints a particular instance of character
 *
 * You can have a rather longer description of the file as well,
 * if you like, and it can span multiple lines.
 *
 * @package    mod_character
 * @copyright  2016 Your Name <contact@alfasz.me>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

// Replace character with the name of your module and remove this line.

require_once(dirname(dirname(dirname(__FILE__))).'/config.php');
require_once(dirname(__FILE__).'/lib.php');

defined('MOODLE_INTERNAL') || die();

require_login();


// Output starts here.
echo $OUTPUT->header();

// Replace the following lines with you own code.

global $CFG;
global $USER;

$userid = $USER->id;

$character_sprite = $DB->get_record('character_sprite', array('userid' => $userid));

if($character_sprite){
        echo '<div id="characterintro" class="box generalbox mod_introbox p-y-1"><div class="no-overflow"><p></p><h4>'.get_string('updatedescription','character').'</h4><br><p></p></div></div>';

        $PAGE->requires->js( new moodle_url($CFG->wwwroot . '/mod/character/c2runtime-custom.js'));
        $PAGE->requires->js( new moodle_url($CFG->wwwroot . '/mod/character/fit-canvas.js'));
	
	echo '<div id="c2canvasdiv" style="text-align:center;">
		<canvas id="c2canvas" width="800" height="600">
			<h3>Your browser does not appear to support HTML5.  Try upgrading your browser to the latest version.  <a href="http://www.whatbrowser.org">What is a browser?</a>
			<br/><br/><a href="http://www.microsoft.com/windows/internet-explorer/default.aspx">Microsoft Internet Explorer</a><br/>
			<a href="http://www.mozilla.com/firefox/">Mozilla Firefox</a><br/>
			<a href="http://www.google.com/chrome/">Google Chrome</a><br/>
			<a href="http://www.apple.com/safari/download/">Apple Safari</a><br/>
			<a href="http://www.google.com/chromeframe">Google Chrome Frame for Internet Explorer</a><br/></h3>
		</canvas>
		<div style="height:30px;"></div>
                <a color:white" class="btn btn-secondary" id="update" href="/my">'.get_string('cancel','character').'</a>
                <div style="height:30px;"></div>
	</div>';
}else{

    echo '<h3>'.get_string('noCharacterYet','character').'</h3>';
    echo '<br><br><p><a color:white" class="btn btn-secondary" id="update" href="/my">'.get_string('cancel','character').'</a></p>';

}



// Finish the page.
echo $OUTPUT->footer();
