
<?php

class CsvFileHandler
{
    # CSV To Array
    protected function csvToArray($filePath)
    {
        // create file handle to read CSV file
        $csvToRead = fopen($filePath, 'r');

        // read CSV file using comma as delimiter
        while (!feof($csvToRead)) {
            $csvArray[] = fgetcsv($csvToRead, 0, ';');
        }

        fclose($csvToRead);
        return $csvArray;
    }

    # Array To CSV 
    protected function arrayToCsv($arr, $filePath)
    {
        // echo 'Arr to CSV';
        // $filePath = __DIR__.'\files\parkingPlaces.csv';
        // $filePath = '../files/parkingPlaces.csv';
        $fp = fopen($filePath, 'w'); // open in write only mode (write at the start of the file)
        for ($row = 0; $row < (count($arr)-1); $row++) {
            fputcsv($fp, $arr[$row], ';');
        }
        fclose($fp);
    }

    //Append Data To CSV
    protected function appendData($name, $email, $password, $filePath)
    {
        // 4- Append data
        $data = array($name, $email, $password);
        // Open file in append mode
        $fp = fopen($filePath, 'a');
        // Append input data to the file  
        fputcsv($fp, $data, ';');
        // close the file
        fclose($fp);
    }
}
