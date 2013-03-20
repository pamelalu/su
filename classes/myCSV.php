<?php
/**
 * Created by JetBrains PhpStorm.
 * User: pstone
 * Date: 3/18/13
 * Time: 8:11 PM
 * This is a CSV parser.  Output is a multi-dimensional array.
 */

class myCSV {

    private $url;
    private $separator;
    private $rowCount;
    public  $data;

    public function __construct($url ='', $separator = ",")
    {
        $this->url = $url;
        $this->separator = $separator;
        $this->rowCount = 0;
        $this->setData();
    }

    /**
     * parse csv into a multi-dimensional array
     */
    public function setData()
    {
        if($this->url != null)
        {
            if (($handle = fopen($this->url, "r")) !== FALSE) {
                while (($rows = fgetcsv($handle)) !== FALSE) {
                    foreach($rows as $row)
                    {
                        $this->data[$this->rowCount][] = $row;
                    }
                    $this->rowCount++;
                }
                fclose($handle);
            }
        }
    }

    /**
     * @return mixed
     * return a multi-dimensional array
     */
    public function getData()
    {
        return $this->data;
    }
}