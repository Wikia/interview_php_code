<?php

require_once 'main.php';

use PHPUnit\Framework\TestCase;

final class FullTest extends TestCase
{
    public function testTest(  ) {
        $response = (new Controller())->submitCarQuestionnaire((object) [
            'name' => 'Tomek',
            'age' => 18,
            'car' => 'Dacia Sandero',
            'engine' => 1.0,
            'userDevice' => 'Android',
            'submissionDate' => '2200-02-02'
        ]);

        $this->assertEquals(
            $response,
            '<div>' .
            '<p>Questionnaire summary:</p>' .
            '<li>Dacia Sandero is an amazing car!</li>' .
            '<li>1 engine is so efficient!</li>' .
            '</div>'
        );
    }
}