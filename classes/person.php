<?php
/**
 * Created by JetBrains PhpStorm.
 * User: pstone
 * Date: 3/19/13
 * Time: 7:47 PM
 * To change this template use File | Settings | File Templates.
 */

class person {
    private $id;
    private $age;
    private $gender;
    private $city;
    private $state;
    private $country;
    private $tags;

    public function __construct($line = array())
    {

    }


    /**
     * @param array $line
     * 0: rating - 0 = seen, but no rating.   1 = thumbup, -1 = thumbdown
     * 1: timestamp = unix timestamp of when they saw the site
     * 2: age = age
     * 3: gender - 1 = male, 2 = female
     * 4: city
     * 5: state
     * 6: country
     * 7+: tag:count
     * */
    public function update($id = 'all')
    {
        //update all data from fileArray
        if($id == 'all')
        {
            $sql = myPDO::getInstance();

            //remove all data in database
            $sql->execute("truncate person_tags");
            $sql->execute("truncate person");

            //get datasource (to add/remove source, go to index.php)
            $fileArray = unserialize (DATASOURCES);

            foreach ($fileArray as $file_name)
            {
                print "<h4>Start updating ".$file_name."...</h4>";

                $csv = new myCSV('urls/'.$file_name.'.csv');

                foreach($csv->data as $line)
                {
                    //insert person
                    $personArray = array();
                    $personArray['person_rating'] = $line[0];
                    $personArray['person_timestamp'] = date('Y-m-d H:i:s', $line[1]);
                    $personArray['person_age'] = $line[2];
                    $personArray['person_gender'] = $line[3];
                    $personArray['person_city'] = $line[4];
                    $personArray['person_state'] = $line[5];
                    $personArray['person_country'] = $line[6];
                    $personArray['person_source'] = $file_name;
                    $person_id = $sql->insert($personArray, 'person');

                    //add tags
                    for($i=7; $i<count($line); $i++)
                    {
                        list($tag_name, $tag_count) = explode(':', $line[$i]);

                        //add person to tag relationship
                        $ptArray = array();
                        $ptArray['person_id'] = $person_id;
                        $ptArray['tag_name'] = $tag_name;
                        $ptArray['tag_count'] = $tag_count;
                        $ptArray['pt_source'] = $file_name;
                        $pt_id = $sql->insert($ptArray, 'person_tags');
                    }

                }
                print "<h4>Complete</h4>";
            }
        }
        //update one entry...no need at this point
        //@todo
        else
        {

        }
    }

    /**
     * @param string $report
     * display html reports
     */
    public function display($report = '')
    {
        if ($report != '')
        {
            $this->getReport($report);
        }
    }

    public function getReport($report)
    {
        $pdo = myPDO::getInstance();
        switch($report)
        {
            case 'user_by_state':
                $sql = "SELECT count(*) value, person_state state FROM person WHERE person_country='USA' group by person_state";
                break;
            case 'user_by_age':
                $sql = "SELECT count(*) value, person_age age FROM person group by person_age";
                break;
            case 'top_ten_tags':
                $sql = "SELECT count(*) count, tag_name FROM `person_tags` group by tag_name order by count desc limit 10";
                break;

        }

        $results = $pdo->execute($sql)->fetchAll(PDO::FETCH_ASSOC);

        $data = fopen('data/'.$report.'.csv', 'w');

        $header ='';
        foreach($results as $row)
        {
            if($header==''){ // do it only once!
                $header = array_keys($row); // get the column names
                fputcsv($data, $header); // put them in csv
            }
            // Export every row to a file
            fputcsv($data, $row);
        }
        echo file_get_contents(BASEDIR.'/html_reports/'.$report.'.html');
    }

  }