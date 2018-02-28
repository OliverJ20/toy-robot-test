## Toy Robot Simulation by Oliver Johnson - PHP laravel version


#### Environment Details

PHP 7.2.0
Laravel framework 5.4.0

#### Instructions

Once the repo has been downloaded: 

1. cd to toy-robot-test folder
2. run the command php artisan robot:start tests/test1.txt 
The text that follows the robot:start, is the folder location and file name to be tested, the folder which files are to be placed can be found at the storage/tests path. 

There are currently three tests that comes with the repo, test1.txt, test2.txt and test3.txt. 

The robot will ignore all commands before being Placed onto the table as well as ignoring all commands that might have it fall of the top.
