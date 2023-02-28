<?php
/**
This file is part of Minecraft-RCON-Console.

    Minecraft-RCON-Console is free software: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 3 of the License, or
    (at your option) any later version.

    Minecraft-RCON-Console is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with Minecraft-RCON-Console.  If not, see <http://www.gnu.org/licenses/>.
*/

require __DIR__ . '/../config.php';
require __DIR__ . '/../utils/mccolors_helper.php';

if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

if (isset($_SESSION['LOGOUT_TIME'])) {
    if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > $_SESSION['LOGOUT_TIME'])) {
        session_unset();     // unset $_SESSION variable for the run-time
        session_destroy();   // destroy session data in storage
        require_once __DIR__ . '/../authsys.php';
    }
}

use xPaw\Query;

define( 'MQ_SERVER_ADDR', $queryHost );
define( 'MQ_SERVER_PORT', $queryPort );
define( 'MQ_TIMEOUT', 1 );

// Display everything in browser, because some people can't look in logs for errors
Error_Reporting( E_ALL | E_STRICT );
Ini_Set( 'display_errors', true );

require __DIR__ . '/query.php';

$Timer = MicroTime( true );

$Info = false;
$Query = null;

try
{
    $Query = new Query( MQ_SERVER_ADDR, MQ_SERVER_PORT, MQ_TIMEOUT );

    $Info = $Query->Query( );

    if( $Info === false )
    {
        /*
         * If this server is older than 1.7, we can try querying it again using older protocol
         * This function returns data in a different format, you will have to manually map
         * things yourself if you want to match 1.7's output
         *
         * If you know for sure that this server is using an older version,
         * you then can directly call QueryOldPre17 and avoid Query() and then reconnection part
         */

        $Query->Close( );
        $Query->Connect( );

        $Info = $Query->QueryOldPre17( );
    }
}
catch( Throwable $e )
{
    $Exception = $e;
}

if( $Query !== null )
{
    $Query->Close( );
}

$Timer = Number_Format( MicroTime( true ) - $Timer, 4, '.', '' );

?>

<!DOCTYPE HTML>

<html lang="en">

    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <title>Minecraft RCON Console</title>

        <script src="//code.jquery.com/jquery-3.6.3.min.js"></script>
        <script src="//code.jquery.com/jquery-migrate-3.4.0.min.js"></script>

        <!-- Latest compiled and minified CSS -->
        <link href="//cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">

        <!-- Latest compiled and minified JavaScript -->
        <script src="//cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>

        <script type="text/javascript" src="../script.js"></script>
        <link rel="stylesheet" type="text/css" href="../style.css" media="screen">

        <link rel="stylesheet" type="text/css" href="../utils/Colors.css">
        <script type="text/javascript" src="../utils/Obfuscated.js"></script>

        <meta http-equiv="refresh" content="1">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
    </head>
    <body class="bg-secondary text-light">
        <svg xmlns="http://www.w3.org/2000/svg" style="display: none;">
            <symbol id="check-circle-fill" viewBox="0 0 16 16">
                <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"/>
            </symbol>
            <symbol id="info-fill" viewBox="0 0 16 16">
                <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2z"/>
            </symbol>
            <symbol id="exclamation-triangle-fill" viewBox="0 0 16 16">
                <path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/>
            </symbol>
        </svg>
        <div class="container-fluid">
            <div class="list-group-item">
                <?php

                try {
                    if ($Info != null) {
                        if (count($Info) <= 1) {
                            throw new Exception();
                        }

                        echo "<div class='d-flex alert alert-success align-items-center fw-bold p-1 mb-2' role='alert'><svg class='status-alert bi flex-shrink-0 me-2' role='img' aria-label='Success'><use xlink:href='#check-circle-fill'/></svg>Server status: Online</div>";
                    } else {
                        throw new Exception();
                    }
                }
                catch (Throwable) {
                    echo "<div class='d-flex alert alert-danger align-items-center fw-bold p-1 mb-2' role='alert'><svg class='status-alert bi flex-shrink-0 me-2' role='img' aria-label='Danger'><use xlink:href='#exclamation-triangle-fill'/></svg>Server status: Offline</div>";
                    return;
                }

                if (empty($Info['description']['text'])) {
                    $desc = mccolors(formatDesc($Info['description']['extra']));
                } else {
                    $desc = mccolors($Info['description']['text'] . "§r");
                }

                echo "Host Port: " . MQ_SERVER_PORT . "<br>";
                echo "Host IP: " . MQ_SERVER_ADDR . "<br>";
                echo "Description: " . $desc . "<br>";
                echo "Version: " . $Info['version']['name'] . "<br>";

                $playersOnline = $Info['players']['online'];
                $playersMax = $Info['players']['max'];

                $division = $playersOnline / $playersMax;
                $percent  = number_format($division * 100, 2);
                echo "Online: $playersOnline / $playersMax ($percent%)<p>";
                $progressClass = "progress-bar progress-bar-striped progress-bar-animated";
                if ($percent > 80)
                    $progressClass = "progress-bar progress-bar-striped progress-bar-animated bg-danger";
                echo "<div class='progress'><div class='$progressClass' role='progressbar' aria-valuenow='$playersOnline' aria-valuemin='0' aria-valuemax='$playersMax' style='width: $percent%;'></div></div>";

                if (isset($Info['players']['sample'])) {
                    $players = $Info['players']['sample'];
                }

                echo "<br>";
                echo "Name of current players online : ";
                if (empty($players)) {
                    echo "No players online";
                } else {
                    foreach ($players as $key => $value) {
                        echo $value['name'];
                        if ($key != (is_countable($players) ? count($players) : 0) - 1)
                            echo ', ';
                    }
                }

                function formatDesc($inputArray) {

                    $output = "";

                    foreach ($inputArray as $pos => $content) {
                        foreach ($content as $key => $value) {
                            switch ($key) {
                                case 'bold':
                                    if ($value) $output .= "§l";
                                    break;

                                case 'italic':
                                    if ($value) $output .= "§o";
                                    break;

                                case 'obfuscated':
                                    if ($value) $output .= "§k";
                                    break;

                                case 'strikethrough':
                                    if ($value) $output .= '§m';
                                    break;

                                case 'underlined':
                                    if ($value) $output .= '§n';
                                    break;

                                case 'color':
                                    switch ($value) {
                                        case 'dark_blue':
                                            if ($value) $output .= '§1';
                                            break;

                                        case 'dark_green':
                                            if ($value) $output .= '§2';
                                            break;

                                        case 'dark_aqua':
                                            if ($value) $output .= '§3';
                                            break;

                                        case 'dark_red':
                                            if ($value) $output .= '§4';
                                            break;

                                        case 'dark_purple':
                                            if ($value) $output .= '§5';
                                            break;

                                        case 'gold':
                                            if ($value) $output .= '§6';
                                            break;

                                        case 'gray':
                                            if ($value) $output .= '§7';
                                            break;

                                        case 'dark_gray':
                                            if ($value) $output .= '§8';
                                            break;

                                        case 'blue':
                                            if ($value) $output .= '§9';
                                            break;

                                        case 'green':
                                            if ($value) $output .= '§a';
                                            break;

                                        case 'aqua':
                                            if ($value) $output .= '§b';
                                            break;

                                        case 'red':
                                            if ($value) $output .= '§c';
                                            break;

                                        case 'light_purple':
                                            if ($value) $output .= '§d';
                                            break;

                                        case 'yellow':
                                            if ($value) $output .= '§e';
                                            break;

                                        case 'white':
                                            if ($value) $output .= '§f';
                                            break;
                                    }
                                    break;
                            }

                            if ($key == 'text') {
                                $output .= $value;
                            }
                        }
                    }

                    return $output;
                }
                ?>
            </div>
        </body>
</html>
