<?php
    class Hangman
    {
        private $word;
        // public $guessed_letter;
        // private $incorrect_guesses;
        private $incorrect_guess_counter;
        private $blanks;
        public $gameOver;
        private $lastGuess;

        function __construct($word, $incorrect_guess_counter, $blanks)
        {
            $this->word = $word;
            // $this->incorrect_guesses = $incorrect_guesses;
            $this->incorrect_guess_counter = $incorrect_guess_counter;
            // $this->guessed_word = $guessed_word;
            $this->blanks = $blanks;
            $this->gameOver = false;
            $this->lastGuess = "";
        }

        function getWord()
        {
            return $this->word;
        }
        function getLastGuess()
        {
            return $this->lastGuess;
        }

        function setWord($new_word)
        {
            $this->word = $new_word;
        }

        function getIncorrectGuesses()
        {
            return $this->incorrect_guesses;
        }

        function setIncorrectGuesses($new_guesses)
        {
            $this->incorrect_guesses = $new_guesses;
        }

        function getIncorrectCounter()
        {
            return $this->incorrect_guess_counter;
        }

        function setIncorrectCounter($new_guesses)
        {
            $this->incorrect_guess_counter = $new_guesses;
        }
        function setBlanks($new_blanks)
        {
            $this->blanks = $new_blanks;
        }
        function getBlanks()
        {
            return $this->blanks;
        }

        function checkGuess($guess)
        {
            if(strpos( implode("", $_SESSION["incorrect_guesses"]), $guess) || strpos( implode("", $_SESSION["correct_guesses"]), $guess)) {
                return true;
            } else {
                return false;
            }
        }
        function guess($guess)
        {

            $index = strpos($this->word, $guess);
            if($index !== FALSE)
            {
                for($i=0; $i<=strlen($this->word)-1; $i++)
                {
                    if ($guess == $this->word[$i])
                    {
                        $this->blanks[$i*2] = $guess;
                    }
                }
                array_push($_SESSION["correct_guesses"], $guess);
                $this->lastGuess = $guess;


            } else {
                $this->incorrect_guess_counter++;
                $this->lastGuess = $guess;
                array_push($_SESSION["incorrect_guesses"], $guess);

            }

        }

        function hasLost()
        {
            if($this->incorrect_guess_counter >= 6)
            {
                $this->gameOver=true;
                return true;
            } else {
                return false;
            }
        }
        function hasWon()
        {
            $newBlank = $this->blanks;
            if (str_replace(" ", "", $newBlank) == $this->word)
            {
                $this->gameOver = true;
                return true;
            } else {
                return false;
            }
        }
        static function getAllCorrectString(){
            return implode(", ",$_SESSION["correct_guesses"]);
        }
        static function getAllIncorrectString(){
            return implode(", ",$_SESSION["incorrect_guesses"]);
        }

    }
?>
