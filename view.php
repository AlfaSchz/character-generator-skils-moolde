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

$id = optional_param('id', 0, PARAM_INT); // Course_module ID, or
$n  = optional_param('n', 0, PARAM_INT);  // ... character instance ID - it should be named as the first character of the module.

if ($id) {
    $cm         = get_coursemodule_from_id('character', $id, 0, false, MUST_EXIST);
    $course     = $DB->get_record('course', array('id' => $cm->course), '*', MUST_EXIST);
    $character  = $DB->get_record('character', array('id' => $cm->instance), '*', MUST_EXIST);
} else if ($n) {
    $character  = $DB->get_record('character', array('id' => $n), '*', MUST_EXIST);
    $course     = $DB->get_record('course', array('id' => $character->course), '*', MUST_EXIST);
    $cm         = get_coursemodule_from_instance('character', $character->id, $course->id, false, MUST_EXIST);
} else {
    error('You must specify a course_module ID or an instance ID');
}

require_login($course, true, $cm);

$event = \mod_character\event\course_module_viewed::create(array(
    'objectid' => $PAGE->cm->instance,
    'context' => $PAGE->context,
));
$event->add_record_snapshot('course', $PAGE->course);
$event->add_record_snapshot($PAGE->cm->modname, $character);
$event->trigger();

// Print the page header.

$PAGE->set_url('/mod/character/view.php', array('id' => $cm->id));
$PAGE->set_title(format_string($character->name));
$PAGE->set_heading(format_string($course->fullname));

/*
 * Other things you may want to set - remove if not needed.
 * $PAGE->set_cacheable(false);
 * $PAGE->set_focuscontrol('some-html-id');
 * $PAGE->add_body_class('character-'.$somevar);
 */
global $CFG;
 
// Output starts here.
echo $OUTPUT->header();

// Conditions to show the intro can change to look for own settings or whatever.
if ($character->intro) {
    echo $OUTPUT->box(format_module_intro('character', $character, $cm->id), 'generalbox mod_introbox', 'characterintro');
}

// Replace the following lines with you own code.

global $USER;
$userid = $USER->id;

$posturl = new moodle_url('/mod/character/view.php', array('id' => $cm->id));


	
    global $CFG;
    global $PAGE;    
    
        $PAGE->requires->js( new moodle_url($CFG->wwwroot . '/mod/character/js/skillsapp.js'));
        $PAGE->requires->js( new moodle_url($CFG->wwwroot . '/mod/character/js/spriteapp.js'));
        
        /**SPRITE**/
        $character_sprite = $DB->get_record('character_sprite', array('userid' => $userid));
        if(!$character_sprite){$character_sprite_current = (object) array("id" => '', "userid"=> '', "username"=> '', "background"=>  0, "skin"=>  0, "hair"=>  0, "eyes"=>  0, "mouth"=>  0, "body"=>  0, "legs"=>  0, "shoes"=>  0, "complements"=>  0 );}else{$character_sprite_current = $character_sprite;}
        
        $nickName = $character_sprite_current->username;
        
        
        echo '<div id="character_div">
                <div id="character_and_menu">
                    <div style="width:60%; margin:20px auto; font-size:20px;"><label class="col-form-label d-inline " for="id_name">Name</label><input id="nickName" type="text" value="'.$nickName.'" class="form-control" style="display:inline;"></div>
                    <canvas class="characterCanvas" id="characterCanvasHair" width="200" height="200" style="z-index:108"></canvas>
                    <canvas class="characterCanvas" id="characterCanvasComplements" width="200" height="200" style="z-index:107"></canvas>
                    <canvas class="characterCanvas" id="characterCanvasEyes" width="200" height="200" style="z-index:106"></canvas>
                    <canvas class="characterCanvas" id="characterCanvasMouth" width="200" height="200" style="z-index:105"></canvas>
                    <canvas class="characterCanvas" id="characterCanvasBody" width="200" height="200" style="z-index:104"></canvas>
                    <canvas class="characterCanvas" id="characterCanvasLegs" width="200" height="200" style="z-index:103"></canvas>
                    <canvas class="characterCanvas" id="characterCanvasShoes" width="200" height="200" style="z-index:102"></canvas>
                    <canvas class="characterCanvas" id="characterCanvasSkin" width="200" height="200" style="z-index:101"></canvas>
                    <canvas class="characterCanvas" id="characterCanvasBackground" width="200" height="200" style="position:relative;z-index:100"></canvas>';
                    
                    foreach($character_sprite_current as $cname => $cvalue){
                        if($cname != 'id' and $cname != 'userid' and $cname != 'username'){
                
                        echo '<span id="'.$cname.'" class="span_sprite" data="'.$cvalue.'"></span>';
                
                        }
                    }
                    echo '<div class="separator"></div>';
                
                echo '<div id="menu">';   
                
                
                    $directory = 'Resources';
                
                    $it = new RecursiveDirectoryIterator($directory);
                            
                    while($it->valid()) {
                        
                        if (!$it->isDot()) {

                            $subPathName = $it->getSubPathName();
                            $key = $it->key();
                            
                            echo  '<img class="character_menu_item" id="character_menu_item_'.$subPathName.'" src="/mod/character/' . $key .'/'. $subPathName . '_1.png"/>';
                        
                        }
                        
                        $it->next();
                    }
                echo '</div>';
        
            echo '</div>';
            
            
            echo '<div id="character_subMenu">';
            
                $it = new RecursiveDirectoryIterator($directory);
                    
                while($it->valid()) {
                    
                    if (!$it->isDot()) {
       
                        
                        $subPath = $it->getSubPathName();
                        
                        echo '<div class="subMenu" id="subMenu_'. $subPath.'">';

                        $itit = new RecursiveDirectoryIterator($directory . '/' . $subPath);

                            while($itit->valid()) {
                    
                                if (!$itit->isDot()) {
                                    
                                    $key = $itit->key();
                                    $value = (int) filter_var($key, FILTER_SANITIZE_NUMBER_INT);
                                    
                                    echo '<img src="/mod/character/' . $key . '" value="'.$value.'" class="item_'.$subPath.' subMenuItem" name="'.$subPath.'" id="subMenuItem_'.$subPath.'_'.$value.'" />';
                                }
                                
                                $itit->next();
                            }   
                            
                        echo '</div>';
                        
                    }
                    
                    $it->next();
                }
                
            echo '</div>';

        echo '</div>';
                    
        
    
        echo '<div style="text-align:center;position:relative;margin-top:30px;">
                <canvas class="characterCanvas" id="characterCanvasGraph" width="600" height="400" ></canvas>';

        
        $character_skills = $DB->get_record('character_skills', array('userid' => $userid));
        if(!$character_skills){$character_skills_current = (object) array("id"=> "", "userid"=> "", "skill1"=> 0, "skill2"=> 0, "skill3"=> 0, "skill4"=> 0, "skill5"=> 0, "skill6"=> 0, "skill7"=> 0, "skill8"=> 0 );}else{$character_skills_current = $character_skills;}
        
        echo "<div id='skillsTextValues'>";
        
        foreach($character_skills_current as $cname => $cvalue){
            if($cname != 'id' and $cname != 'userid'){
                $text_skill = get_string($cname, 'character');
                
                echo "<div style='margin: 20px auto;' id=$cname data-value=$cvalue data-name-trans=$text_skill><span style='display:inline-block; width:30%;text-align:left;font-size:14px;'>$text_skill</span>";
                
                for($i = 1; $i < 11; $i++){
                    ((int)$cvalue >= $i) ? $background = 'rgba(0, 0, 255, 0.5)' : $background = 'rgba(0, 0, 255, 0.2)';
                
                    echo "<span id=$cname$i data-value=$i data-name=$cname style='display:inline-block; width:5%;margin:0 1%;background:".$background.";cursor:pointer;'>&nbsp;</span>";
                }
                echo "</div>";
            }
        }                   
        echo "</div>";
                    
        echo '</div>';


        
        
        echo '<div id="inputs">';
        
        
                //include locallib.php
                require_once('locallib.php');
                
                //Instantiate shuffleletter_user_form 
                $mformsprite = new character_sprite_form((string)$posturl);
                
                //Form processing and displaying is done here
                if ($mformsprite->is_cancelled()) {
                    //Handle form cancel operation, if cancel button is present on form
                    redirect($posturl);
                    
                } else if ($mformdata = $mformsprite->get_data()) {
                    //In this case you process validated data. $mformsprite->get_data() returns data posted in form.
                    
                    $record_sprite = new stdClass();

                    $record_sprite->userid = $userid;
                    $record_sprite->username = $mformdata->username;
                    $record_sprite->background = $mformdata->background;
                    $record_sprite->skin = $mformdata->skin;
                    $record_sprite->hair = $mformdata->hair;
                    $record_sprite->eyes  = $mformdata->eyes;
                    $record_sprite->mouth = $mformdata->mouth;
                    $record_sprite->body = $mformdata->body;
                    $record_sprite->legs = $mformdata->legs;
                    $record_sprite->shoes = $mformdata->shoes;
                    $record_sprite->complements = $mformdata->complements;
                    
                    if(!$character_sprite){
                        $DB->insert_record('character_sprite', $record_sprite, false);
            
                    }else{
                        $record_sprite->id = $character_sprite->id;
                        $DB->update_record('character_sprite', $record_sprite, false);
                    }
                    
                    $record_skills = new stdClass();
            
                    $record_skills->userid = $userid;
                    $record_skills->skill1 = $mformdata->skill1;
                    $record_skills->skill2 = $mformdata->skill2;
                    $record_skills->skill3 = $mformdata->skill3;
                    $record_skills->skill4 = $mformdata->skill4;
                    $record_skills->skill5 = $mformdata->skill5;
                    $record_skills->skill6 = $mformdata->skill6;
                    $record_skills->skill7 = $mformdata->skill7;
                    $record_skills->skill8 = $mformdata->skill8;
                    
                    if(!$character_skills){        
                        $DB->insert_record('character_skills', $record_skills, false);
                    }else{
                        $record_skills->id = $character_skills->id;
                        $DB->update_record('character_skills', $record_skills, false);
                    }
                    
                    redirect($posturl);

                                    
                } else {
                    // this branch is executed if the form is submitted but the data doesn't validate and the form should be redisplayed
                    // or on the first display of the form.

                    //displays the form
                    $mformsprite->display();
                }
        
        echo '</div>';


// Finish the page.
echo $OUTPUT->footer();



