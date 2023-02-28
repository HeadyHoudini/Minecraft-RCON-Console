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
require __DIR__ . '/config.php';
?>

<!DOCTYPE HTML>

<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    <title>Minecraft RCON Console</title>

    <script src="//code.jquery.com/jquery-3.6.3.min.js"></script>
    <script src="//code.jquery.com/jquery-migrate-3.4.0.min.js"></script>

    <!-- Latest compiled and minified CSS -->
    <link href="//cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">

    <!-- Latest compiled and minified JavaScript -->
    <script src="//cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN"
            crossorigin="anonymous"></script>

    <script type="text/JavaScript" src="script.js"></script>

    <link rel="stylesheet" type="text/css" href="style.css" media="screen">
    <meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body>
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
<!-- Stack the columns on mobile by making one full-width and the other half-width -->
<div class="container-fluid content pt-2">
    <div class="alert alert-primary d-flex align-items-center fw-bold pt-2 mb-2" role="alert" id="alertMessenge">
        Minecraft RCON Console.
        <label class="ms-auto" id="session"></label>
    </div>
    <div class="alert alert-info fw-bold p-0 mb-2">
        <center><?php echo "Server: {$serverName}"; ?></center>
    </div>
    <div class="row h-75">
        <div class="col-lg-8 console">
            <div class="card h-100">
                <div class="card-header bg-dark text-light">
                    <h3>Console</h3>
                </div>
                <div class="card bg-secondary px-0 h-100">
                    <ul class="list-group flex-fill" id="groupConsole">
                        <li class="d-flex list-group-item list-group-item-info align-items-center">
                            <svg class="console-alert bi flex-shrink-0 me-2" role="img" aria-label="Info">
                                <use xlink:href="#info-fill"/>
                            </svg>
                            <span class="console-text">Welcome to Minecraft RCON Console.</span>
                        </li>
                        <li class="d-flex list-group-item list-group-item-info align-items-center">
                            <svg class="console-alert bi flex-shrink-0 me-2" role="img" aria-label="Info">
                                <use xlink:href="#info-fill"/>
                            </svg>
                            <span class="console-text">View all command at&nbsp;<a href="https://minecraft.fandom.com/wiki/Commands"
                                                                             class="alert-link" target="_blank">https://minecraft.fandom.com/wiki/Commands</a></span>
                        </li>
                        <li class="d-flex list-group-item list-group-item-info align-items-center">
                            <svg class="console-alert bi flex-shrink-0 me-2" role="img" aria-label="Info">
                                <use xlink:href="#info-fill"/>
                            </svg>
                            <span class="console-text">View item name and id at&nbsp;<a href="https://www.minecraftinfo.com/idlist.htm"
                                                                                  class="alert-link" target="_blank">https://www.minecraftinfo.com/idlist.htm</a></span>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="d-flex checkbox panel panel-default panel-body justify-content-between py-3">
                <label class="d-flex text-light flex-wrap align-items-center">
                    <input class="form-check-input mt-0" type="checkbox" id="chkAutoScroll" checked="true"> Auto scroll
                </label>
                <button type="button" class="btn btn-outline-warning" tabindex="0" id="btnClearLog"
                        style="float:right;"><span class="glyphicon glyphicon-remove-sign"></span> Clear Console
                </button>
            </div>

            <div class="input-group">
                <input type="text" class="form-control bg-secondary text-light" id="txtCommand">
                <div class="input-group-btn">
                    <button type="button" class="btn btn-outline-primary" tabindex="-1" id="btnSend"><span
                                class="glyphicon glyphicon-arrow-right"></span> Send
                    </button>
                </div>
            </div>
        </div>

        <div class="col-lg-4 status">
            <div class="card h-100">
                <div class="card-header bg-dark text-light">
                    <h3>Server Status & Info</h3>
                </div>
                <div class="card-body bg-secondary px-0 pt-2">
                    <iframe class="w-100 h-100" src="query/status.php" frameBorder="0">Browser not compatible.</iframe>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
<footer class="footer mt-auto py-3 float-end">
    <div class="container-fluid text-light">
        Minecraft RCON Console 3.0 | Developed by <a href="https://github.com/HeadyHoudini"
                                                     target="_blank">HeadyHoudini</a> (Based on <a
                href="https://github.com/ekaomk" target="_blank">0ekaomk</a>)
    </div>
</footer>
</html>
