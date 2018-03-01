## Toy Robot Simulation by Oliver Johnson - PHP laravel version

###Problem Description 
Toy Robot Simulator
Description:The application is a simulation of a toy robot moving on a square tabletop, of dimensions 5 units x 5 units.
There are no other obstructions on the table surface. The robot is free to roam around the surface of the table, but must be prevented from falling to destruction. 
Any movement that would result in the robot falling from the table must be prevented, however further valid movement commands must still be allowed.

#### Environment Details
Composer install (for an instruction guide to installing composer on your machine https://getcomposer.org/doc/00-intro.md)
PHP 7.2.0
Laravel framework 5.4.0


#### Instructions

Once the above enviroment details have been obtained and repo has been downloaded/cloned into your desired folder destination: 


Run the command php artisan (`robot:start tests/test1.txt`) 

The text that follows the robot:start, is the folder location and file name to be tested, the folder which files are to be placed can be found at the storage/tests path within the project. 

There are currently three tests that comes with the repo, test1.txt, test2.txt and test3.txt. 

Output for test1.txt = The robot reports it is at 5,5,North
Output for test2.txt = The robot reports it is at 0,0,EAST
Output for test3.txt = The robot reports it is at 3,3,West

####NOTES

When creating your own text files make sure to place them in the same location as the test1.txt etc files.

When writing commands keep in mind the robot will ignore all commands before being placed onto the table as well as any commands that might cause it to fall of the 5 x 5 units table. 


