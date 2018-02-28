<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\robotController;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;




class RobotStart extends Command
{
    private $direction = null,
        $robotPlace = null;



    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'robot:start {file}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->robotPlace = ['x' => null,'y' => null];
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */



    public function changeLocation($x, $y)
    {
        $newLocation = [
            'x' => $this->robotPlace['x'] + $x,
            'y' => $this->robotPlace['y'] + $y
        ];
       // $this->robotPlace = $newLocation;
        return $newLocation;
    }

    public function positionValidation($robotLocation)
    {
        $this->line('testing postion x thing ' . $robotLocation['x']);
        $this->line('testing position y thing ' . $robotLocation['y']);

        if ($robotLocation['y'] > 5)
        {
            $this->line('YEAH WE GOT IN THIS BITCH');
        }

        if ($robotLocation['x'] > 5 || $robotLocation['x'] < 0)
        {
            return false;
        }
        elseif ($robotLocation['y'] > 5 || $robotLocation['y'] < 0)
        {
            $this->line('DO WE GET HERE');
            return false;

        }
        else{
            return true;
        }
    }

    public function robotHasBeenPlaced()
    {
        if($this->direction === null ||$this->robotPlace['x'] === null || $this->robotPlace['y'] === null)
        {
            return false;
        }
        else{
            return true;
        }
    }

    public function place($x, $y, $direction_face)
    {
        $newLocation = [
            'x' => $x,
            'y' => $y
        ];
        $this->robotPlace = $newLocation;
        $this->direction = $direction_face;
    }

    public function move()
    {
        if(!$this->robotHasBeenPlaced())
        {
            return;
        }

        if ($this->direction == 'NORTH')
        {
            $moveLocation = $this->changeLocation(0,1);
            $this->line('testing a thing ' . $moveLocation['y']);
            if($this->positionValidation($moveLocation))
            {
                $this->line('WHEN WE GET INTO TRUE');
                $this->robotPlace = $moveLocation;
            }
            else
            {
                $this->line('WHEN WE GET INTO FALSE');
                return;
            }
        }
        elseif ($this->direction == 'SOUTH')
        {
            $moveLocation = $this->changeLocation(0,-1);

            if($this->positionValidation($moveLocation))
            {
                //return $moveLocation;
                $this->robotPlace = $moveLocation;
            }
            else
            {
                return;
            }
        }
        elseif ($this->direction == 'EAST')
        {
            $moveLocation = $this->changeLocation(1,0);

            if($this->positionValidation($moveLocation))
            {
                $this->robotPlace = $moveLocation;
            }
            else
            {
                return;
            }
        }
        elseif ($this->direction == 'WEST')
        {
            $moveLocation = $this->changeLocation(-1,1);

            if($this->positionValidation($moveLocation))
            {
                $this->robotPlace = $moveLocation;
            }
            else
            {
                return;
            }
        }
    }

    public function right()
    {
        if(!$this->robotHasBeenPlaced())
        {
            return;
        }

        if ($this->direction == 'NORTH')
        {
            $this->direction ='EAST';

        }
        elseif ($this->direction == 'SOUTH')
        {
            $this->direction = 'WEST';
        }
        elseif ($this->direction == 'EAST')
        {
            $this->direction = 'SOUTH';
        }
        elseif ($this->direction == 'WEST')
        {
            $this->direction ='NORTH';
        }
    }

    public function left()
    {
        if(!$this->robotHasBeenPlaced())
        {
            return;
        }

        if ($this->direction == 'NORTH')
        {
           $this->direction ='WEST';

        }
        elseif ($this->direction == 'SOUTH')
        {
            $this->direction = 'EAST';
        }
        elseif ($this->direction == 'EAST')
        {
           $this->direction = 'NORTH';
        }
        elseif ($this->direction == 'WEST')
        {
            $this->direction ='SOUTH';
        }
    }
    public function report()
    {
        $report = 'The robot is at '. $this->robotPlace['x'] . ',' . $this->robotPlace['y'] . ',' .$this->direction;
        return $report;
    }



    public function handle()
    {
       // $this->robotPlace = ['x' => 1,'y' => 2];

             $while = 1;
//NEED TO PUT IN VALIDATION STUFF AND CANT GO OVER THE TABLE.'

        //MAKING SURE THE POSITION IS VALID.

       // $contents = file::get(storage_path($this->argument('file')), 'r');
      //  $this->line('hello '. $contents);

        $command_text = file(storage_path($this->argument('file')), FILE_IGNORE_NEW_LINES);
        $count = count($command_text);
      // $this->line('testing '. $command_text[0][0]);
      //  $command_position = str_split($command_text[0],3);
      // $command_direction = str_split($command_text[0],5);
      //  $this->line('teshhhhting '. $command_direction[2]);
      //  $this->line('teshhhhting '. $command_position[2]);


        for ($i =0; $i < $count; $i++)
        {
            if($command_text[$i][0] == "P")
            {
                $command_position = str_split($command_text[$i],3);
                $command_direction = str_split($command_text[$i],5);

               $this->place($command_position[2][0], $command_position[2][2], $command_direction[2]);

            }
            elseif ($command_text[$i] == 'MOVE')
            {
                $this->move();
           //     $this->line('testing '. $this->move()[0]);
            }
            elseif($command_text[$i] == 'LEFT')
            {
                $this->left();
            }
            elseif($command_text[$i] == 'RIGHT')
            {
                $this->right();
            }
            elseif($command_text[$i] == 'REPORT')
            {
                $this->line('the robot reports ' . $this->report());
            }
        }


     //   $this->line('bye    '. $command_text[2]);
      //  $this->line('bye    '. $command_text[1]);

     //   $this->line('bye    '. $count);

       // $command = $this->ask ('What is your robot command');


       /* while ($while =  1) {
            if ($command == 'MOVE') {
                //$this->move();
                $this->line($this->move());
            }
             $commands = $this->ask('any more commands ?');
            $this->line('what was typed '. $commands);
        }*/



     /*   $difficulty =  $this->option('difficulty');

        if(!$difficulty){
            $difficulty = 'easy';
        }


        $this->line('Welcome '.$this->argument('user').", starting test in difficulty : ". $difficulty);

        $questions = [
            'easy' => [
                'How old are you ?', "What is the name of your mother?",
                'Do you have 3 parents ?','Do you like Javascript?',
                'Do you know what is a JS promise?'
            ],
            'hard' => [
                'Why the sky is blue?', "Can a kangaroo jump higher than a house?",
                'Do you think i am a bad father?','why the dinosaurs disappeared?',
                "why don't whales have gills?"
            ]
        ];

        $questionsToAsk = $questions[$difficulty];
        $answers = [];

        foreach($questionsToAsk as $question){
            $answer = $this->ask($question);
            array_push($answers,$answer);
        }

        $this->info("Thanks for do the quiz in the console, your answers : ");

        for($i = 0;$i <= (count($questionsToAsk) -1 );$i++){
            $this->line(($i + 1).') '. $answers[$i]);
        }*/

    }
}
