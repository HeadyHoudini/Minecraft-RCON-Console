$( document ).ready(() => {
    let lastCommand = "",
        txtCommand = $("#txtCommand"),
        groupConsole = $("#groupConsole");

    txtCommand.bind("enterKey",() => {
        lastCommand = $("#txtCommand").val();
        sendCommand(lastCommand);
    });

    txtCommand.keyup(function(e){
        if(e.keyCode === 13)
        {
            $(this).trigger("enterKey");
            $(this).val("");
        }
        if(e.keyCode === 38)
        {
            $(this).val(lastCommand);
        }
    });

    $( "#btnSend" ).click(() => {
        if (txtCommand.val() !== "") $("#btnSend").prop('disabled', true);
        sendCommand(txtCommand.val());
        if ($("#chkAutoScroll").is(':checked')) scrollLogsDown();
    });

    $( "#btnClearLog" ).click(() => {
        groupConsole.empty();
        alertInfo("Console has been cleared.");
    });
});

function logSuccess(log) {
    $("#groupConsole").append(`<li class="d-flex list-group-item list-group-item-success align-items-center"><svg class="console-alert bi flex-shrink-0 me-2" role="img" aria-label="Success"><use xlink:href="#check-circle-fill"/></svg><span class="console-text">${getCurrentTime()} <- ${log}</span></li>`);
    $("#btnSend").prop('disabled', false);
    clearOldLogs();
}

function logInfo(log) {
    $("#groupConsole").append(`<li class="d-flex list-group-item list-group-item-info align-items-center"><svg class="console-alert bi flex-shrink-0 me-2" role="img" aria-label="Info"><use xlink:href="#info-fill"/></svg><span class="console-text">${getCurrentTime()} -> ${log}</span></li>`);
    $("#btnSend").prop('disabled', false);
    clearOldLogs();
}

function logWarning(log) {
    $("#groupConsole").append(`<li class="d-flex list-group-item list-group-item-warning align-items-center"><svg class="console-alert bi flex-shrink-0 me-2" role="img" aria-label="Warning"><use xlink:href="#exclamation-triangle-fill"/></svg><span class="console-text">${getCurrentTime()} <- ${log}</span></li>`);
    $("#btnSend").prop('disabled', false);
    clearOldLogs();
}

function logDanger(log) {
    $("#groupConsole").append(`<li class="d-flex list-group-item list-group-item-danger align-items-center"><svg class="console-alert bi flex-shrink-0 me-2" role="img" aria-label="Danger"><use xlink:href="#exclamation-triangle-fill"/></svg><span class="console-text">${getCurrentTime()} <- ${log}</span></li>`);
    $("#btnSend").prop('disabled', false);
    clearOldLogs();
}

function alertSuccess(messenge) {
    let alertMessage = $("#alertMessenge");
    let originalElement = alertMessage.html(),
        originalAttr = alertMessage.attr('class');
    let fadeTimer = 10 / 60;

    alertMessage.fadeOut( "slow", () => {
        alertMessage.attr('class', 'alert alert-success d-flex align-items-center fw-bold pt-2 mb-2');
        alertMessage.html(`<svg class="console-alert bi flex-shrink-0 me-2" role="img" aria-label="Success"><use xlink:href="#check-circle-fill"></use></svg>${messenge}`);
        alertMessage.fadeIn("slow", () => {
        });

        setTimeout(() => {
            alertMessage.fadeOut("slow", () => {
                alertMessage.attr('class', originalAttr);
                alertMessage.html(originalElement);
            });
            alertMessage.fadeIn("slow", () => {
            });
        },fadeTimer*60*1000);
    });
}

function alertInfo(messenge) {
    let alertMessage = $("#alertMessenge");
    let originalElement = alertMessage.html(),
        originalAttr = alertMessage.attr('class');
    let fadeTimer = 10 / 60;

    alertMessage.fadeOut( "slow", () => {
        alertMessage.attr('class', 'alert alert-info d-flex align-items-center fw-bold pt-2 mb-2');
        alertMessage.html(`<svg class="console-alert bi flex-shrink-0 me-2" role="img" aria-label="Info"><use xlink:href="#info-fill"></use></svg>${messenge}`);
        alertMessage.fadeIn("slow", () => {
        });

        setTimeout(() => {
            alertMessage.fadeOut("slow", () => {
                alertMessage.attr('class', originalAttr);
                alertMessage.html(originalElement);
            });
            alertMessage.fadeIn("slow", () => {
            });
        }, fadeTimer * 60 * 1000);
    });
}

function alertWarning(messenge) {
    let alertMessage = $("#alertMessenge");
    let originalElement = alertMessage.html(),
        originalAttr = alertMessage.attr('class');
    let fadeTimer = 20 / 60;

    alertMessage.fadeOut( "slow", () => {
        alertMessage.attr('class', 'alert alert-warning d-flex align-items-center pt-2 mb-2');
        alertMessage.html(`<svg class="console-alert bi flex-shrink-0 me-2" role="img" aria-label="Warning"><use xlink:href="#exclamation-triangle-fill"></use></svg>${messenge}`);
        alertMessage.fadeIn("slow", () => {
        });

        setTimeout(() => {
            alertMessage.fadeOut("slow", () => {
                alertMessage.attr('class', originalAttr);
                alertMessage.html(originalElement);
            });
            alertMessage.fadeIn("slow", () => {
            });
        }, fadeTimer * 60 * 1000);
    });
}

function alertDanger(messenge) {
    let alertMessage = $("#alertMessenge");
    let originalElement = alertMessage.html(),
        originalAttr = alertMessage.attr('class');
    let fadeTimer = 20 / 60;

    alertMessage.fadeOut( "slow", () => {
        alertMessage.attr('class', 'alert alert-danger d-flex align-items-center pt-2 mb-2');
        alertMessage.html(`<svg class="console-alert bi flex-shrink-0 me-2" role="img" aria-label="Danger"><use xlink:href="#exclamation-triangle-fill"></use></svg>${messenge}`);
        alertMessage.fadeIn("slow", () => {
        });

        setTimeout(() => {
            alertMessage.fadeOut("slow", () => {
                alertMessage.attr('class', originalAttr);
                alertMessage.html(originalElement);
            });
            alertMessage.fadeIn("slow", () => {
            });
        }, fadeTimer * 60 * 1000);
    });
}

function sendCommand(command) {
    if (command === "") {
        alertDanger("Please enter command.");
        return;
    }

    logInfo(command)

    clearOldLogs();
    $.post("rcon/index.php", {cmd: command}).done((data) => {
        if (data.indexOf("[HERE]") !== -1) {
            alertDanger("Unknown command : Please check your&nbsp;<a href='https://minecraft.fandom.com/wiki/Commands' target='_blank'> command.</a>");
            logWarning(data);
            clearOldLogs();

            if ($("#chkAutoScroll").is(':checked')) scrollLogsDown();
            return;
        } else if (data.indexOf("Usage") !== -1) {
            alertWarning(data);
            logWarning(data);
            clearOldLogs();

            if ($("#chkAutoScroll").is(':checked')) scrollLogsDown();
            return;
        } else if (data.indexOf("Unknown command") !== -1) {
            alertDanger("Unknown command : Please check your&nbsp;<a href='https://minecraft.fandom.com/wiki/Commands' target='_blank'> command.</a>");
            logWarning(data);
            clearOldLogs();

            if ($("#chkAutoScroll").is(':checked')) scrollLogsDown();
            return;
        } else if (data.indexOf("offline") !== -1) {
            alertDanger("Server is currently not reachable!");
            logDanger(data);
            clearOldLogs();

            if ($("#chkAutoScroll").is(':checked')) scrollLogsDown();
            return;
        } else if (data.indexOf("creds_incorrect") !== -1) {
            alertDanger("Couldn't connect to server! Check your RCON Credentials in&nbsp;<span class='fw-bold'>config.php</span>.");
            logDanger("Connection error!");
            clearOldLogs();

            if ($("#chkAutoScroll").is(':checked')) scrollLogsDown();
            return;
        }

        alertSuccess("Send success!");
        logSuccess(data);

        $("#btnSend").prop('disabled', false);
        clearOldLogs();
        if ($("#chkAutoScroll").is(':checked')) scrollLogsDown();
    }).fail(() => {
        alertDanger("Error!");
        logDanger("Error!")

        $("#btnSend").prop('disabled', false);
        clearOldLogs();
        if ($("#chkAutoScroll").is(':checked')) scrollLogsDown();
    });
    if ($("#chkAutoScroll").is(':checked')) scrollLogsDown();
}

function clearOldLogs() {
    let logItemSize = $("#groupConsole li").size();

    if (logItemSize > 50) {
        $('#groupConsole li:first').remove();
    }
}

function scrollLogsDown() {
    $("#groupConsole").scrollTop($("#groupConsole").get(0).scrollHeight);
}

function getCurrentTime() {
    let currentdate = new Date();

    return currentdate.getDate() + "/"
        + (currentdate.getMonth() + 1) + "/"
        + currentdate.getFullYear() + " @ "
        + currentdate.getHours() + ":"
        + currentdate.getMinutes() + ":"
        + currentdate.getSeconds();
}