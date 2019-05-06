// #######################################################
// # Curl Command Control
// #######################################################

/**
 * The generated curl command object
 * that will be sent to AJAX/JS.
 */
let curl_command = {};

/**
 * Submit the constructed CURL request.
 */
function submitRequest()
{
    $("#curl-submit-button").prop('enabled', false);
    $("#submit-button-text").text("Loading...");
    let ajaxRequest = {
        headers: headersAsAjaxHeaders(),
        data: curl_command.payload,
        method: curl_command.method,
        dataType: 'text',
        crossDomain: true,
        timeout: 15000
    };

    if (curl_command.hasOwnProperty('http_auth') && curl_command.http_auth.user != null) {
        ajaxRequest["beforeSend"] = function (xhr) {
            xhr.withCredentials = true;
            xhr.setRequestHeader ("Authorization", "Basic " + btoa(curl_command.http_auth.user + ":" + curl_command.http_auth.pass));
        };
    }
    
    $.ajax(curl_command.address + generateParamStr(), ajaxRequest)
     .done(function(data, textStatus, request) {
        displayResult(data, textStatus, request);
        $("#curl-submit-button").prop('enabled', true);
        $("#submit-button-text").text("Submit");
     })
     .fail(function (xhr, status, error) {
         displayResult('Error: ' + error + ', Code: ' + xhr.status + ' ' + status + ', Response: ' + xhr.responseText, status, xhr);
         $("#curl-submit-button").prop('enabled', true);
         $("#submit-button-text").text("Submit");
     });
}

/**
 * Display the result box.
 *
 * @param {mixed} result 
 */
function displayResult(result, textStatus, request)
{
    $("#curl-response-spacer-top").css('display', 'block');
    $("#curl-response").css('display', 'block');

    let data = result;
    try {
        data = JSON.parse(data);
        data = JSON.stringify(data, null, 4);
    } catch (e) {}

    let out = request.status + ' ' + textStatus + "\r\n\r\n";

    if (request != null) {
        out += request.getAllResponseHeaders();
        out += "\r\n";
    }

    out += data;

    //data = data.replace(/(?:\r\n|\r|\n)/g, '\\n');
    response_editor.setValue(out, -1);
}

/**
 * Convert the headers to AJAX formatted headers.
 */
function headersAsAjaxHeaders()
{
    let ajax_headers = {};
    let i;
    for (i = 0; i< curl_command.headers.length; i++) {
        let current_header = curl_command.headers[i];
        ajax_headers[current_header.header] = current_header.value;
    }

    return ajax_headers;
}

/**
 * Generate the Parameter String
 */
function generateParamStr()
{
    let address = $("#curl-address").val();
    
    let paramStr = "";
    curl_command.parameters = current_parameters;
    let i;
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

    return paramStr;
}

/**
 * Update the Generated Curl command based
 * on the selections made on the form.
 */
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

    curl_command.address = address;
    curl_command.method = method;

    $("#curl-generated-empty").css("display", "none");
    $("#curl-generated-wrapper").css("display", "block");
    $("#curl-generated-copy").css("display", "block");

    // Generate Headers
    curl_command.headers = current_headers;
    let headerStr = "";
    let i;
    for (i = 0; i < current_headers.length; ++i) {
        let current_header = current_headers[i];

        headerStr += "-H '"+current_header.header+": "+
                     current_header.value+"' \\\r\n     ";
        
    }

    // Generate parameters
    let paramStr = generateParamStr();

    // Generate payload
    let payloadStr = "";
    curl_command.payload = current_payload;
    if (current_payload) {
        payloadStr = "-d '"+current_payload+"'";
    }

    // Generate Auth
    let basic_user = $("#curl-basic-auth-username").val();
    let basic_pass = $("#curl-basic-auth-password").val();
    let basicAuthStr = "";
    curl_command.http_auth = {
        "user": basic_user,
        "pass": basic_pass
    };
    if (basic_user && basic_pass) {
        basicAuthStr = "-u " + basic_user + ":" + basic_pass + " \\\r\n     ";
    }

    // Generate "insecure"
    let insecure = $("#curl-insecure-cb").checked;
    let insecureStr = (insecure) ? "-k " : "";
    curl_command.insecure = insecure;

    // Generate HTTP Version
    let http = $("#httpVersionRadio1:checked").val();
    let httpStr = "";
    curl_command.http_version = http;
    if (http) {
        httpStr = "--http" + http + " ";
    }

    // Generate TLS Version
    let tls = $("#tlsVersionRadio1:checked").val();
    let tlsStr = "";
    curl_command.tls_version = tls;
    if (tls) {
        tlsStr = "--" + tls + " ";
    }

    // Set the final CURL Command
    $("#curl-generated").text(
        "curl " + insecureStr + httpStr + tlsStr + basicAuthStr + "-X " + method + " \\\r\n     "+
        headerStr +
        payloadStr + ((payloadStr)?" \\\r\n     ":"") +
        "'" + address + paramStr + "'"
    );
}

// #######################################################
// # Sharing URL Control
// #######################################################

/**
 * Sets the URL to be loaded and disables
 * most of the form.
 *
 * @param {string} url 
 */
function setGeneratedUrl(url)
{
    $("#share-url").text(url);
    $("#share-url").css('cursor', 'default');
    $("#copy-url-group").html(
        $('#copy-url-group').html() +
        '<div class="input-group-append" id="url-copy-button">' +
            '<button class="btn btn-secondary" type="button" id="copy-button" onclick="copyTextToClipboard(\'share-url\', \'copyUrlButtonText\')" data-toggle="tooltip" data-placement="top" title="Copy URL"><i class="far fa-copy"></i>&nbsp; <span id="copyUrlButtonText">Copy</span></button>' +
            '<a href="'+url+((in_dev)?"&":"?")+'duplicate" class="btn btn-secondary" data-toggle="tooltip" data-placement="top" title="Duplicate & Edit"><i class="fas fa-clone"></i>&nbsp; Duplicate</a>' +
        '</div>'
    );

    // Remove/disable controls
    $("#curl-address").prop('disabled', true);
    $("#curl-method").prop('disabled', true);
    $("#curl-headers-table").css('margin-bottom', '0px');
    $("#curl-headers-add-form").empty().remove();
    $("#curl-headers-empty-message-content").text('No headers defined in this request.');
    $("#curl-headers-empty-message-spacer").remove();
    $("#curl-parameters-table").css('margin-bottom', '0px');
    $("#curl-parameters-add-form").empty().remove();
    $("#curl-parameters-empty-message-content").text('No parameters defined in this request.');
    $("#curl-parameters-empty-message-spacer").remove();
    // TODO: Payload (make work like response)
    $("#curl-basic-auth-username").prop('disabled', true);
    $("#curl-basic-auth-password").prop('disabled', true);
    $("#curl-insecure-cb").prop('disabled', true);
    $("#httpVersionRadio1").prop('disabled', true);
    $("#httpVersionRadio2").prop('disabled', true);
    $("#httpVersionRadio3").prop('disabled', true);
    $("#httpVersionRadio4").prop('disabled', true);
    $("#httpVersionRadio5").prop('disabled', true);
    $("#tlsVersionRadio1").prop('disabled', true);
    $("#tlsVersionRadio2").prop('disabled', true);
    $("#tlsVersionRadio3").prop('disabled', true);
    $("#tlsVersionRadio4").prop('disabled', true);
    $("#tlsVersionRadio5").prop('disabled', true);
    $("#tlsVersionRadio6").prop('disabled', true);
    $("#tlsVersionRadio7").prop('disabled', true);
    $("#tlsVersionRadio8").prop('disabled', true);

    // We do not disable the "Send With" options,
    // nor are they saved with a request. This is
    // because the end user should be the deciding
    // factor in which technology is used to send 
    // the constructed request.

    url_loaded = true;

    // Update header / parameter display.
    updateParameterDisplay(true);
    updateHeaderDisplay(true);

    $('[data-toggle="tooltip"]').tooltip();
}

/**
 * Generate a new Curl URL.
 */
function generateCurlUrl()
{
    if (! url_loaded) {
        $("#share-url").text('Generating URL...');
        $.post('{{>url (L) ajax/generateurl}}', curl_command)
        .done(function( data ) {
            if (data.hasOwnProperty('url')) {
                setGeneratedUrl(data.url);
            } else {
                if (data.hasOwnProperty('error')) {
                    alert(data.error);
                }
                $("#share-url").html('Something went wrong, <a href="#__generate_url" onclick="generateCurlUrl()">try agin</a>.');
            }
        })
        .fail(function(xhr, status, error){
            $("#share-url").html('Something went wrong, <a href="#__generate_url" onclick="generateCurlUrl()">try agin</a>.');
        });
    }
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
 * Removes a specific parameter at an index.
 *
 * @param {int} index 
 */
function removeParameter(index)
{
    if (! url_loaded) {
        current_parameters.splice(index, 1);
        updateParameterDisplay(false);
    }
}

/**
 * Add a new parameter based on the values provided.
 */
function addParameter()
{
    if (! url_loaded) {
        let parameter = $("#curl-add-parameter-name").val();
        let value  = $("#curl-add-parameter-value").val();

        if (! parameter) {
            return;
        }

        current_parameters.push({"parameter": parameter, "value": value});

        updateParameterDisplay(true);
    }
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

        let curl_parameters = $("#curl-parameters");
        curl_parameters.empty();

        let i;
        for (i = 0; i < current_parameters.length; ++i) {
            let current_parameter = current_parameters[i];
            let param_val = !current_parameter.value ? '(null)' : current_parameter.value;

            curl_parameters.html(
                curl_parameters.html() + 
                "<tr>" +
                    "<th scope='row'>"+current_parameter.parameter+"</th>" + 
                    "<td><code>"+param_val+"</code></td>" + 
                    "<td style='width: 1%; white-space: nowrap;'>"+
                        (
                            (!url_loaded)
                                ? "<a href='#___deleteparameter' class='btn btn-danger' onclick='removeParameter("+i+")' data-toggle='tooltip' data-placement='top' title='Remove Parameter'><i class='fas fa-trash-alt'></i></a>":""
                        )
                    +"</td>" +
                "</tr>"
            );

            $('[data-toggle="tooltip"]').tooltip();
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
 * Removes a specific header at an index.
 *
 * @param {int} index 
 */
function removeHeader(index)
{
    if (! url_loaded) {
        current_headers.splice(index, 1);
        updateHeaderDisplay(false);
    }
}

/**
 * Add a new header based on the values provided.
 */
function addHeader()
{
    if (! url_loaded) {
        let header = $("#curl-add-header-name").val();
        let value  = $("#curl-add-header-value").val();

        if (! header || ! value) {
            return;
        }

        current_headers.push({"header": header, "value": value});

        updateHeaderDisplay(true);
    }
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

        let curl_headers = $("#curl-headers");
        curl_headers.empty();

        let i;
        for (i = 0; i < current_headers.length; ++i) {
            let current_header = current_headers[i];

            curl_headers.html(
                curl_headers.html() + 
                "<tr>" +
                    "<th scope='row'>"+current_header.header+"</th>" + 
                    "<td><code>"+current_header.value+"</code></td>" + 
                    "<td style='width: 1%; white-space: nowrap;'>"+((!url_loaded)?"<a href='#___deleteheader' class='btn btn-danger' onclick='removeHeader("+i+")' data-toggle='tooltip' data-placement='top' title='Remove Header'><i class='fas fa-trash-alt'></i></a>":"")+"</td>" +
                "</tr>"
            );
        }

        $('[data-toggle="tooltip"]').tooltip();
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

/**
 * Used to copy text to the clipboard from
 * the curl-generated element.
 */
function copyTextToClipboard(id, control_id) {
    let textArea = document.createElement("textarea");
  
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
  
  
    let text = $("#"+id).text();
    textArea.value = text;
  
    document.body.appendChild(textArea);
    textArea.focus();
    textArea.select();
  
    try {
      let successful = document.execCommand('copy');
      let msg = successful ? 'successful' : 'unsuccessful';
      console.log('Copying text command was ' + msg);
    } catch (err) {
      console.log('Oops, unable to copy');
    }
  
    document.body.removeChild(textArea);

    $("#"+control_id).text("Copied!");

    setTimeout(function() {
        $("#"+control_id).text("Copy");
    }, 2000);
  }