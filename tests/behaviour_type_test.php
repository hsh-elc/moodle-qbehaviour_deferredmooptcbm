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

namespace qbehaviour_deferredmooptcbm;

use question_display_options;
use question_engine;

defined('MOODLE_INTERNAL') || die();

global $CFG;
require_once(__DIR__ . '/../../../engine/lib.php');
require_once(__DIR__ . '/../../../engine/tests/helpers.php');


/**
 * Unit tests for the deferred feedback with certainty base marking behaviour for MooPT Questions.
 *
 * @package    qbehaviour_deferredmooptcbm
 * @copyright  2009 The Open University
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class behaviour_type_test extends \qbehaviour_walkthrough_test_base {

    /** @var qbehaviour_deferredmooptcbm_type */
    protected $behaviourtype;

    public function setUp(): void {
        parent::setUp();
        $this->behaviourtype = question_engine::get_behaviour_type('deferredmooptcbm');
    }

    public function test_is_archetypal() {
        $this->assertFalse($this->behaviourtype->is_archetypal());
    }

    public function test_get_unused_display_options() {
        $this->assertEquals(array('generalfeedback', 'rightanswer'),
                $this->behaviourtype->get_unused_display_options());
    }

    public function test_can_questions_finish_during_the_attempt() {
        $this->assertFalse($this->behaviourtype->can_questions_finish_during_the_attempt());
    }

    public function test_adjust_random_guess_score() {
        $this->assertEquals(0, $this->behaviourtype->adjust_random_guess_score(0));
        $this->assertEquals(1, $this->behaviourtype->adjust_random_guess_score(1));
    }

    public function test_calculate_bonus() {
        $this->assertEquals(0.05,  $this->behaviourtype->calculate_bonus(1, 1/2));
        $this->assertEquals(-0.01, $this->behaviourtype->calculate_bonus(2, 9/10));
        $this->assertEquals(0,     $this->behaviourtype->calculate_bonus(3, 1));
    }
}
