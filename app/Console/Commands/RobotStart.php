<?php

namespace App\Console\Commands;
use Illuminate\Console\Command;

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

    public function changeLocation($x, $y)
    {
        $newLocation = [
            'x' => $this->robotPlace['x'] + $x,
            'y' => $this->robotPlace['y'] + $y
        ];
        return $newLocation;
    }

    public function positionValidation($robotLocation)
    {
        if ($robotLocation['x'] > 5 || $robotLocation['x'] < 0)
        {
            return false;
        }
        elseif ($robotLocation['y'] > 5 || $robotLocation['y'] < 0)
        {
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
            if($this->positionValidation($moveLocation))
            {
                $this->robotPlace = $moveLocation;
            }
            else
            {
                return;
            }
        }
        elseif ($this->direction == 'SOUTH')
        {
            $moveLocation = $this->changeLocation(0,-1);

            if($this->positionValidation($moveLocation))
            {
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
        $report = 'it is at '. $this->robotPlace['x'] . ',' . $this->robotPlace['y'] . ',' .$this->direction;
        return $report;
    }

    public function handle()
    {
        $command_text = file(storage_path($this->argument('file')), FILE_IGNORE_NEW_LINES);
        $count = count($command_text);


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
                $this->line('The robot reports ' . $this->report());
            }
        }
    }
}
