<?php
echo "<link rel=\"stylesheet\" href=\"style.css\">";
date_default_timezone_set('America/Toronto');
// pulls the data from the form in index.html and puts it into a variable
$sDate = new DateTime($_GET['date']);
$eDate = clone($sDate);

// create Activity class that will be used to store the data that we pull from the API
class Activity
{
    // variables for each piece of info we will pull from the API
    private $activityType;
    private $time;
    private $vehicle;
    private $driverName;
    private $route;

    
    // getters and setter for each variable
    public function setActivityType ($activityType)
    {$this->activityType = $activityType;}
    public function getActivityType()
    {return $this->activityType;}

    public function setTime($time)
    {$this->time = $time;}
    public function getTime()
    {return $this->time;}

    public function setVehicle($vehicle)
    {$this->vehicle = $vehicle;}
    public function getVehicle()
    {return $this->vehicle;}

    public function setDriverName($driverFirstName, $driverLastName)
    {$this->driverName = $driverFirstName . " " . $driverLastName;}
    public function getDriverName()
    {return $this->driverName;}

    public function setRoute($route)
    {$this->route = $route;}
    public function getRoute()
    {return $this->route;}

}

// API Pull using cUrl
$activityArray = array(); //will store the activities
error_reporting(1);
//times are irrelavant as it pull the whole day no matter what you enter
$startDate = $sDate->format('Y-m-d') . 'T00:00:00';
$endDate = $eDate->format('Y-m-d') . 'T00:00:00';
$searchCriteria = "{\"startDate\": \"" . $startDate . "\",\"endDate\": \"" . $endDate . "\"}";
$apiKey = '******';
$url = '******';
$headers = array();
$headers[] = 'Content-Type: application/json';
$headers[] = 'Accept: application/json';
$headers[] = 'X-Apikey: ' . $apiKey;

$ch = curl_init();
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_POSTFIELDS, $searchCriteria);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

$jsonExec = curl_exec($ch);
if(curl_errno($ch))
{
	echo 'Error:' . curl_error($ch);
}

curl_close($ch);

// decode the json into an array we can use
$json = json_decode($jsonExec, true); 
$length = count($json['Data'], 0);
echo "<h1> Driver Activities Found!</h1><strong>Date:</strong> " . substr($startDate,0,10) . "<hr>";

//inset the data from the json into an object array
$j = 0;
if ($length > 0)
{
    for ($i = 0; $i < $length; $i++) // create new activity for each activity
    {
        $activityArray[$j] = new Activity();
        $activityArray[$j]->setActivityType ($json['Data'][$i]['ActivityType']);
		$activityArray[$j]->setTime ($json['Data'][$i]['StartDateTime']);
        $activityArray[$j]->setVehicle ($json['Data'][$i]['VehicleName']);
        $activityArray[$j]->setDriverName ($json['Data'][$i]['DriverFirstName'], $json['Data'][$i]['DriverLastName']);
        $activityArray[$j]->setRoute ($json['Data'][$i]['RouteId']);
        $j++;
    }
}

// code below used to print out the info we grabbed into a browser
$count = 0;
echo "<table border=\"3\">
        <tr>
            <th>Truck</th>
            <th>Date</th>
            <th>Time</th>
            <th>Driver Name</th>
            <th>Activity</th>
            <th>Route</th>
        </tr>";
foreach($activityArray as $activity)
{
    // there ifs check to see if a box from the form was not checked and if it wasnt then it wont print out that object
    if ($activity->getActivityType() == "Gate crossing" && !isset($_GET['gate']))
    continue;
    if ($activity->getActivityType() == "Waiting" && !isset($_GET['waiting']))
    continue;
    if ($activity->getActivityType() == "Break" && !isset($_GET['break']))
    continue;
    if ($activity->getActivityType() == "Meal" && !isset($_GET['meal']))
    continue;
    if ($activity->getActivityType() == "Breakdown" && !isset($_GET['broke']))
    continue;
    if ($activity->getActivityType() == "Refueling" && !isset($_GET['fuel']))
    continue;
    if ($activity->getActivityType() == "Mechanical inspection" && !isset($_GET['mech']))
    continue;
    // echos the info into the browser
    echo "<tr>";
    echo "<td>" . substr($activity->getVehicle(),3) . "</td>";
    echo "<td>" . substr($activity->getTime(), 0, 10) . "</td>";
    echo "<td>" . substr($activity->getTime(), 11) . "</td>";
    echo "<td>" . $activity->getDriverName() .  "</td>";
    echo "<td>" . $activity->getActivityType() . "</td>";
    echo "<td>" . $activity->getRoute() . "</td>";
    echo "</tr>";
    $count++;
}
echo "</table>";
echo "<br><strong>Total: </strong>" . $count . " Activites found.<hr>";
?>