<html>
    <head>
        <link rel="stylesheet" href="style.css">
    </head>
    <body>
        <div style= "margin-right: 50%;">
            <fieldset class="fieldset">
                <legend><h1 style="border-style: ridge; padding: 5px;">Driver Activities</h1></legend>
                <form action="DriverActivities.php" method="get" >
                    <table>
                        <tr>
                            <td>Date:</td>
                            <td><input type="date" name="date"></td>
                        </tr>
                        <tr>
                            <td>Activities:</td>
                            <td><input type="checkbox" id="gate" name="gate" value="gate"><label for="gate">Gate Crossing</label></td>
                            <td><input type="checkbox" id="waiting" name="waiting" value="waiting"><label for="waiting">Waiting</label></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td><input type="checkbox" id="break" name="break" value="break"><label for="break">Break</label></td>
                            <td><input type="checkbox" id="meal" name="meal" value="meal"><label for="meal">Meal</label></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td><input type="checkbox" id="broke" name="broke" value="broke"><label for="broke">Breakdown</label></td>
                            <td><input type="checkbox" id="fuel" name="fuel" value="fuel"><label for="fuel">Refueling</label></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td><input type="checkbox" id="mech" name="mech" value="mech"><label for="mech">Mechanical Inspection</label></td>
                        </tr>
                        <tr>
                        <td><input type="submit"></td>
                        </tr>
                    </table>
                </form>
                <code>Code is located at C:\Users\Staff\Downloads\Xampp\htdocs\scripts\WorkingCode\ on ******</code>
            </fieldset>
        </div>
    </body>
</html>