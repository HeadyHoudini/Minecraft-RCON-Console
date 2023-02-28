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

require __DIR__ . '/rcon.php';
require __DIR__ . '/../config.php';

$host = $rconHost; // Server host name or IP
$port = $rconPort;                      // Port rcon is listening on
$password = $rconPassword; // rcon.password setting set in server.properties
$timeout = 3;                       // How long to timeout.
 
$rcon = new Rcon($host, $port, $password, $timeout);

if(!isset($_POST['cmd'])) return;

if ($rcon->connect())
{
	$rcon->send_command($_POST['cmd']);
	$_SESSION['LAST_ACTIVITY'] = time();
	echo preg_replace("/§./", "", (string) $rcon->get_response()); //remove some invalid char
} else {
    echo "creds_incorrect";
}
?>