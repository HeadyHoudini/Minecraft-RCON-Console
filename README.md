# Minecraft RCON Console
##### Tool for send server command via RCON protocal of minecraft server by website.

![alt tag](/screenshot/pc.jpg)

### Version

##### 3.0
* Updated PHP Version to 8.2.
* Updated jquery version to 3.6.3.
* Updated jquery-migrate version to 3.4.0.
* Updated bootstrap version to 5.3.
* Changed protocol from query to ping (Used code from [xPaw](https://xpaw.me/))
* Changed style
* Added error messages.
* Added styles for motd. (Used code from [Minecrell](https://github.com/Minecrell))

##### 2.1
* Changed query library.
* Fixed responsive on mobile.
* Updated jquery version.
* Updated bootstrap version.

##### 2.0
* Added responsive design.
* Changed theme.
* Fixed file path.
* Added console clear button.
* Updated jquery version.
* Updated bootstrap version.

##### 1.0
* Added commands send directly to server.
* Added server status and number of current player online.
* Added a list all names of current player online.

# Setting up
1. Download/Clone source file
2. Edit "config.php" (port number and RCON password on you.)
    ```php
    $rconHost = "127.0.0.1";
    $rconPort = 25575;
    $rconPassword = "rconpassword";
    $queryHost = "127.0.0.1";
    $queryPort = 25565;
    ```
3. Edit "authsys.php" to create accounts (information in file) - the default username is `admin`, default password `1234abcd`
4. Upload all file to your server.
5. Edit your "server.properties" file.
add (port number and RCON password on you.)
    ```
    query.port=25565
    rcon.port=25575
    rcon.password=rconpassword
    ```
    and change ``` enable-rcon=true ```
6. Restart your server.
7. Done.
