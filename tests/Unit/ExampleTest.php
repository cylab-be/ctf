<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;

use App\Question;

class ExampleTest extends TestCase
{
    /**
     * Test verification of flag based on regular expressions
     *
     * @group regex
     *
     * @return void
     */
    public function testVerifyQuestionWithRegex()
    {
        $question = new Question();
        $question->flag = "dokos?|hydra";
        
        $this->assertTrue($question->verify("dokos"));
        $this->assertTrue($question->verify("doko"));
        $this->assertTrue($question->verify("DOKOS"));
        $this->assertTrue($question->verify("hydra"));
        $this->assertFalse($question->verify("other"));
        
        // true because the provided answer CONTAINS the correct sequences (dokos)
        $this->assertTrue($question->verify("dokos-with-someting-added"));
        
        // use ^ and $ to force exact correspondance
        $question = new Question();
        $question->flag = "^dokos$";
        $this->assertTrue($question->verify("dokos"));
        $this->assertFalse($question->verify("dokos-with-something-added"));
    }
}
