function generateShCurlCommand()
{
    // Generate address & method
    let address = $("#curl-address").val();
    let method  = $("#curl-method").val();

    if (! address) {
        $("#curl-generated-empty").css("display", "block");
        $("#curl-generated-wrapper").css("display", "none");
        $("#curl-generated-copy").css("display", "none");
        return;
    }

    $("#curl-generated-empty").css("display", "none");
    $("#curl-generated-wrapper").css("display", "block");
    $("#curl-generated-copy").css("display", "block");

    // Generate Headers
    let headerStr = "";
    var i;
    for (i = 0; i < current_headers.length; ++i) {
        let current_header = current_headers[i];

        headerStr += "-H '"+current_header.header+": "+
                     current_header.value+"' \\\r\n     ";
    }

    // Generate parameters
    let paramStr = "";
    for (i = 0; i < current_parameters.length; ++i) {
        let current_parameter = current_parameters[i];

        if (paramStr == "" && address.indexOf("?") == -1) {
            paramStr += "?";
        } else {
            paramStr += "&";
        }
        paramStr += current_parameter.parameter;

        if (current_parameter.value) {
            paramStr += "="+current_parameter.value;
        }
    }

    // Generate payload
    let payloadStr = "";
    if (current_payload) {
        payloadStr = "-d '"+current_payload+"'";
    }

    // Generate Auth
    let basic_user = $("#curl-basic-auth-username").val();
    let basic_pass = $("#curl-basic-auth-password").val();
    let basicAuthStr = "";
    if (basic_user && basic_pass) {
        basicAuthStr = "-u " + basic_user + ":" + basic_pass + " \\\r\n     ";
    }

    // Generate "insecure"
    let insecure = $("#curl-insecure-cb").prop('checked');
    let insecureStr = (insecure) ? "-k " : "";

    // Set the final CURL Command
    $("#curl-generated").text(
        "curl " + insecureStr + basicAuthStr + "-X " + method + " \\\r\n     "+
        headerStr +
        payloadStr + ((payloadStr)?" \\\r\n     ":"") +
        "'" + address + paramStr + "'"
    );
}

// #######################################################
// # Payload Control
// #######################################################

var current_payload = "";

/**
 * Called when the editor text is modified.
 *
 * @param {ACE Editor} editor 
 */
function payloadChanged(editor)
{
    let payload = editor.getValue();
    payload = payload.replace(/(?:\r\n|\r|\n)/g, '\\n');
    current_payload = payload;
    generateShCurlCommand();
}

// #######################################################
// # Parameter Control
// #######################################################

/**
 * Local Parameter storage
 */
var current_parameters = [];

/**
 * Removes a specific parameter at an index.
 *
 * @param {int} index 
 */
function removeParameter(index)
{
    current_parameters.splice(index, 1);

    updateParameterDisplay(false);
}

/**
 * Add a new parameter based on the values provided.
 */
function addParameter()
{
    let parameter = $("#curl-add-parameter-name").val();
    let value  = $("#curl-add-parameter-value").val();

    if (! parameter) {
        return;
    }

    current_parameters.push({"parameter": parameter, "value": value});

    updateParameterDisplay(true);
}

/**
 * Update the displayed parameters.
 * 
 * @param {bool} clearInputs Clear the input boxes.
 */
function updateParameterDisplay(clearInputs)
{
    if (current_parameters.length < 1) {
        $("#curl-parameters-empty-message").css("display", "block");
        $("#curl-parameters-empty-message-spacer").css("display", "block");
        $("#curl-parameters-table").css("display", "none");
    } else {
        $("#curl-parameters-empty-message").css("display", "none");
        $("#curl-parameters-empty-message-spacer").css("display", "none");
        $("#curl-parameters-table").css("display", "block");

        var curl_parameters = $("#curl-parameters");
        curl_parameters.empty();

        var i;
        for (i = 0; i < current_parameters.length; ++i) {
            let current_parameter = current_parameters[i];
            let param_val = !current_parameter.value ? '(null)' : current_parameter.value;

            curl_parameters.html(
                curl_parameters.html() + 
                "<tr>" +
                    "<th scope='row'>"+current_parameter.parameter+"</th>" + 
                    "<td><code>"+param_val+"</code></td>" + 
                    "<td style='width: 1%; white-space: nowrap;'><a href='#___deleteparameter' class='btn btn-danger' onclick='removeParameter("+i+")'><i class='fas fa-trash-alt'></i></a></td>" +
                "</tr>"
            );
        }
    }

    if (clearInputs) {
        $("#curl-add-parameter-name").val("");
        $("#curl-add-parameter-value").val("");
    }

    generateShCurlCommand();
}


// #######################################################
// # Header Control
// #######################################################

/**
 * Local Header storage
 */
var current_headers = [];

/**
 * Removes a specific header at an index.
 *
 * @param {int} index 
 */
function removeHeader(index)
{
    current_headers.splice(index, 1);

    updateHeaderDisplay(false);
}

/**
 * Add a new header based on the values provided.
 */
function addHeader()
{
    let header = $("#curl-add-header-name").val();
    let value  = $("#curl-add-header-value").val();

    if (! header || ! value) {
        return;
    }

    current_headers.push({"header": header, "value": value});

    updateHeaderDisplay(true);
}

/**
 * Update the displayed headers.
 * 
 * @param {bool} clearInputs Clear the input boxes.
 */
function updateHeaderDisplay(clearInputs)
{
    if (current_headers.length < 1) {
        $("#curl-headers-empty-message").css("display", "block");
        $("#curl-headers-empty-message-spacer").css("display", "block");
        $("#curl-headers-table").css("display", "none");
    } else {
        $("#curl-headers-empty-message").css("display", "none");
        $("#curl-headers-empty-message-spacer").css("display", "none");
        $("#curl-headers-table").css("display", "block");

        var curl_headers = $("#curl-headers");
        curl_headers.empty();

        var i;
        for (i = 0; i < current_headers.length; ++i) {
            let current_header = current_headers[i];

            curl_headers.html(
                curl_headers.html() + 
                "<tr>" +
                    "<th scope='row'>"+current_header.header+"</th>" + 
                    "<td><code>"+current_header.value+"</code></td>" + 
                    "<td style='width: 1%; white-space: nowrap;'><a href='#___deleteheader' class='btn btn-danger' onclick='removeHeader("+i+")'><i class='fas fa-trash-alt'></i></a></td>" +
                "</tr>"
            );
        }
    }

    if (clearInputs) {
        $("#curl-add-header-name").val("");
        $("#curl-add-header-value").val("");
    }

    generateShCurlCommand();
}

// #######################################################
// # Copy Button
// #######################################################

function copyTextToClipboard() {
    var textArea = document.createElement("textarea");
  
    //
    // *** This styling is an extra step which is likely not required. ***
    //
    // Why is it here? To ensure:
    // 1. the element is able to have focus and selection.
    // 2. if element was to flash render it has minimal visual impact.
    // 3. less flakyness with selection and copying which **might** occur if
    //    the textarea element is not visible.
    //
    // The likelihood is the element won't even render, not even a
    // flash, so some of these are just precautions. However in
    // Internet Explorer the element is visible whilst the popup
    // box asking the user for permission for the web page to
    // copy to the clipboard.
    //
  
    // Place in top-left corner of screen regardless of scroll position.
    textArea.style.position = 'fixed';
    textArea.style.top = 0;
    textArea.style.left = 0;
  
    // Ensure it has a small width and height. Setting to 1px / 1em
    // doesn't work as this gives a negative w/h on some browsers.
    textArea.style.width = '2em';
    textArea.style.height = '2em';
  
    // We don't need padding, reducing the size if it does flash render.
    textArea.style.padding = 0;
  
    // Clean up any borders.
    textArea.style.border = 'none';
    textArea.style.outline = 'none';
    textArea.style.boxShadow = 'none';
  
    // Avoid flash of white box if rendered for any reason.
    textArea.style.background = 'transparent';
  
  
    let text = $("#curl-generated").text();
    textArea.value = text;
  
    document.body.appendChild(textArea);
    textArea.focus();
    textArea.select();
  
    try {
      var successful = document.execCommand('copy');
      var msg = successful ? 'successful' : 'unsuccessful';
      console.log('Copying text command was ' + msg);
    } catch (err) {
      console.log('Oops, unable to copy');
    }
  
    document.body.removeChild(textArea);

    $("#copyButtonText").text("Copied!");

    setTimeout(function() {
        $("#copyButtonText").text("Copy");
    }, 2000);
  }