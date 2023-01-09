<?php

    //Creation of the class allows for all the related functions to be under one name
    class Services{

        //Essentially the "main" function, where the program begins
        function run(){
            
            $continue = True;

            //Error checking for the correct input
            while($continue == True){

                $input = (string)readline("Begin? (Y/N): ");
                if(strcasecmp($input, "Y") == 0){

                    //If correct input entered the program will proceed to the function in the class named "locateServices"
                    echo "\n\n";
                    $this->locateServices();

                }elseif(strcasecmp($input, "N") == 0){

                    //In this case, will end the program
                    $continue = False;

                }else{

                    echo "Please enter a valid input\n";

                }

            }
    
        }
        //Private function as this should only be accessed from within the class
        private function locateServices(){

            //Variable initialisations
            $amtServices = 0;
            $inputValid = False;
            $arrayRef = array();
            $arrayCentre = array();
            $arrayService = array();
            $arrayCountry = array();
            $arrayLocateServices = array();
            $temp = "";
            $inc = 0;

            //Locates the CSV file and reads it, in this case it is assumed that the CSV contains 4 columns so a list is made to assign array values
            //to multiple variables at a time
            $csv = 'services.csv';
            $fileHandler = fopen($csv,'r');

            //The comma is the separation between values so ',' is used, length is set to a high value such as 1000
            while(list($ref, $centre, $service, $country) = fgetcsv($fileHandler, 1000, ',')){

                //Values from CSV are set into columns based on the column name
                $arrayRef[] = $ref;
                $arrayCentre[] = $centre;
                $arrayService[] = $service;
                $arrayCountry[] = $country;

            }
            //Error checking again for valid country code
            while($inputValid == False){

                $input = (string)readline("Enter country code: ");

                //Loops through the country array to check if the input is the same as one of the country codes that exist
                //$c is set initially to 1 so this does not include the first value, being the column identifying string
                for($c=1; $c < count($arrayCountry); $c++){

                    //Case does not matter so the strings are compared without taking case into consideration
                    if(strcasecmp($input, $arrayCountry[$c]) == 0){

                        $inputValid = True;

                        //Tracks the number of services that have been found for the country
                        $amtServices++;

                        //Iteration number is added to an array, we can use this to easily find the corresponding information for the services from the country
                        $arrayLocateServices[] = $c;

                    }

                }
                if($inputValid !== True){

                    echo "Error, please select valid country code\n";

                }else{

                    //Lists the information by retrieving the data from the arrays established for each of the columns and the number using the array with the iteration numbers
                    echo $input . " is a valid code!\n\n";
                    echo "Total number of services: " . $amtServices . "\n\n";
                    echo "Services in " . $input . " include:\n\n";
                    for($c=0; $c < count($arrayLocateServices); $c++){

                        echo $arrayService[$arrayLocateServices[$c]] . "\n";
                        echo "Located at the " . $arrayCentre[$arrayLocateServices[$c]] . " centre\n";
                        echo "With the reference " . $arrayRef[$arrayLocateServices[$c]] . "\n\n";

                    }

                }

            }

        }

    }
    //Creates an instance of the class and then runs the "run" function
    $service = new Services();
    $service->run();
    
?>