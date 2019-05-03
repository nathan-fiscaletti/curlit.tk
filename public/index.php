<html>
    <head>
        <title>Curl It! — HTTP Requests from your browser</title>
        <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css" />
        <link rel="stylesheet" href="assets/css/style.css" />

        <!-- Font Awesome -->
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
    </head>
    <body>
        <div class="container">
            <!-- Header -->
            <br />
            <div class="header clearfix">
                <nav>
                    <ul class="nav nav-pills float-right">
                        <li class="nav-item">
                            <a class="nav-link active" href="#">Curl It!&nbsp;<span class="sr-only">(current)</span></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Contact</a>
                        </li>
                    </ul>
                </nav>
            </div>

            <br />
            <div class="card">
                <div class="card-body">
                    <h1 class="display-4">Curl It!</h1>
                    <p class="lead">Curl It! allows you to send HTTP requests from within your browser using either PHP or JavaScript! Try it out below!</p>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-8">
                    <!-- Main Form -->
                    <br />
                    <form>
                        <div class="card">
                            <div class="card-body">
                                <!-- Request -->
                                <div class="card dark-card">
                                    <h5 class="card-header">Request</h5>
                                    <div class="card-body">
                                        <div class="form-row">
                                            <div class="col-sm-8">
                                                <div class="input-group mb-8">
                                                    <div class="input-group-prepend">
                                                        <div class="input-group-text"><i class="fas fa-globe-americas"></i></div>
                                                    </div>
                                                    <input type="text" class="form-control" placeholder="Address..." id="curl-address" onchange="generateShCurlCommand();" onkeypress="this.onchange();" onpaste="this.onchange();" oninput="this.onchange();" />
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                                <select class="form-control" id="curl-method" onchange="generateShCurlCommand()">
                                                    <option selected>GET</option>
                                                    <option>HEAD</option>
                                                    <option>POST</option>
                                                    <option>PUT</option>
                                                    <option>DELETE</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <br />

                                <!-- Headers -->
                                <div class="card dark-card">
                                    <h5 class="card-header pointer-cursor" id="headersHeading" data-toggle="collapse" data-target="#headersBody" aria-expanded="true" aria-controls="headersBody">
                                        Headers (<code>-H</code>)
                                        <span class="section-dd">
                                            <i class="fas fa-chevron-down"></i>
                                        </span>
                                    </h5>
                                    <div id="headersBody" class="collapse">
                                        <div class="card-body">
                                            <div class="form-row">
                                                <div class="col-sm-12">
                                                    <?php // TODO: Read headers from URL db ?>
                                                    <div class="card" id="curl-headers-empty-message" style="display: block;">
                                                        <h5 class="card-body" style="margin: 0px;">
                                                            Add a new header using the form below.
                                                        </h5>
                                                    </div>
                                                    <br id="curl-headers-empty-message-spacer" />
                                                    <table id="curl-headers-table" class="table table-borderless" style="display: none;">
                                                        <thead>
                                                            <tr>
                                                            <th scope="col">Header</th>
                                                            <th scope="col">Value</th>
                                                            <th scope="col"></th>
                                                            </tr>
                                                        </thead>
                                                        <tbody id="curl-headers">
                                                            <!-- Header Visuals will go here -->
                                                        </tbody>
                                                    </table>
                                                    <div class="form-row">
                                                        <div class="col-sm-5">
                                                            <div class="input-group mb-8">
                                                                <div class="input-group-prepend">
                                                                    <div class="input-group-text"><i class="fas fa-heading"></i></div>
                                                                </div>
                                                                <input type="text" class="form-control" placeholder="Header..." id="curl-add-header-name" />
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-5">
                                                            <input type="text" class="form-control" placeholder="Value..." id="curl-add-header-value" />
                                                        </div>
                                                        <div class="col-sm-2">
                                                            <a href="#___addheader" class="btn btn-info float-right full-w-button" onclick="addHeader();"><i class="fas fa-plus-circle"></i>&nbsp; Add</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <br />

                                <!-- Parameters -->
                                <div class="card dark-card">
                                    <h5 class="card-header pointer-cursor" id="parametersHeading" data-toggle="collapse" data-target="#parametersBody" aria-expanded="true" aria-controls="parametersBody">
                                        Parameters
                                        <span class="section-dd">
                                            <i class="fas fa-chevron-down"></i>
                                        </span>
                                    </h5>
                                    <div id="parametersBody" class="collapse">
                                        <div class="card-body">
                                            <div class="form-row">
                                                <div class="col-sm-12">
                                                    <?php // TODO: Read headers from URL db ?>
                                                    <div class="card" id="curl-parameters-empty-message" style="display: block;">
                                                        <h5 class="card-body" style="margin: 0px;">
                                                            Add a new parameter using the form below.
                                                        </h5>
                                                    </div>
                                                    <br id="curl-parameters-empty-message-spacer" />
                                                    <table id="curl-parameters-table" class="table table-borderless" style="display: none;">
                                                        <thead>
                                                            <tr>
                                                                <th scope="col">Parameter</th>
                                                                <th scope="col">Value</th>
                                                                <th scope="col"></th>
                                                            </tr>
                                                        </thead>
                                                        <tbody id="curl-parameters">
                                                            <!-- Parameter Visuals will go here -->
                                                        </tbody>
                                                    </table>
                                                    <div class="form-row">
                                                        <div class="col-sm-5">
                                                            <div class="input-group mb-8">
                                                                <div class="input-group-prepend">
                                                                    <div class="input-group-text"><i class="fab fa-product-hunt"></i></div>
                                                                </div>
                                                                <input type="text" class="form-control" placeholder="Parameter..." id="curl-add-parameter-name" />
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-5">
                                                            <input type="text" class="form-control" placeholder="Value..." id="curl-add-parameter-value" />
                                                        </div>
                                                        <div class="col-sm-2">
                                                            <a href="#___addparameter" class="btn btn-info float-right full-w-button" onclick="addParameter();"><i class="fas fa-plus-circle"></i>&nbsp; Add</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <br />

                                <!-- Payload -->
                                <div class="card dark-card">
                                    <h5 class="card-header pointer-cursor" id="payloadHeading" data-toggle="collapse" data-target="#payloadBody" aria-expanded="true" aria-controls="payloadBody">
                                        Payload (<code>-d</code>)
                                        <span class="section-dd">
                                            <i class="fas fa-chevron-down"></i>
                                        </span>
                                    </h5>
                                    <div id="payloadBody" class="collapse">
                                        <div class="card-body" style="height: 225px;">
                                            <div class="form-row">
                                                <div class="col-sm-12">
                                                    <div id="editor" style="background-color: #202020 !important;"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <br />

                                <!-- Authentication -->
                                <div class="card dark-card">
                                    <h5 class="card-header pointer-cursor" id="authHeading" data-toggle="collapse" data-target="#authBody" aria-expanded="true" aria-controls="authBody">
                                        HTTP Basic Authentication (<code>-u</code>)
                                        <span class="section-dd">
                                            <i class="fas fa-chevron-down"></i>
                                        </span>
                                    </h5>
                                    <div id="authBody" class="collapse">
                                        <div class="card-body">
                                            <div class="form-row">
                                                <div class="col-sm-6">
                                                    <div class="input-group mb-8">
                                                        <div class="input-group-prepend">
                                                            <div class="input-group-text"><i class="fas fa-user"></i></div>
                                                        </div>
                                                        <input type="text" class="form-control" id="curl-basic-auth-username" placeholder="Username..." onchange="generateShCurlCommand();" onkeypress="this.onchange();" onpaste="this.onchange();" oninput="this.onchange();" />
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="input-group mb-8">
                                                        <div class="input-group-prepend">
                                                            <div class="input-group-text"><i class="fas fa-lock"></i></div>
                                                        </div>
                                                        <input type="password" class="form-control" id="curl-basic-auth-password" placeholder="Password..." onchange="generateShCurlCommand();" onkeypress="this.onchange();" onpaste="this.onchange();" oninput="this.onchange();" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <br />

                                <!-- Options -->
                                <div class="card dark-card">
                                    <h5 class="card-header pointer-cursor" id="optionsHeading" data-toggle="collapse" data-target="#optionsBody" aria-expanded="true" aria-controls="optionsBody">
                                        Options
                                        <span class="section-dd">
                                            <i class="fas fa-chevron-down"></i>
                                        </span>
                                    </h5>
                                    <div id="optionsBody" class="collapse">
                                        <div class="card-body">
                                            <div class="form-row">
                                                <div class="col-sm-4">
                                                    <label><b>Curl Options: </b></label>
                                                </div>
                                                <div class="col-sm-4">
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="checkbox" id="curl-insecure-cb" value="true" onclick="generateShCurlCommand()">
                                                        <label class="form-check-label" for="curl-insecure-cb">Insecure (<code>-k</code>)</label>
                                                    </div>
                                                </div>
                                                <div class="col-sm-4">
                                                    <!-- Other option -->
                                                </div>
                                            </div>
                                            <br />
                                            <div class="form-row">
                                                <div class="col-sm-4">
                                                    <label><b>HTTP Version: </b></label>
                                                </div>
                                                <div class="col-sm-4">
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio" name="httpVersionRadio" id="httpVersionRadio1" value="option1" checked>
                                                        <label class="form-check-label" for="inlineRadio1">Default</label>
                                                    </div>
                                                </div>
                                                <div class="col-sm-4">
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio" name="httpVersionRadio" id="httpVersionRadio1" value="option1">
                                                        <label class="form-check-label" for="inlineRadio1">HTTP 1.0</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <br />
                                            <div class="form-row">
                                                <div class="col-sm-4">
                                                    <label>&nbsp;</label>
                                                </div>
                                                <div class="col-sm-4">
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio" name="httpVersionRadio" id="httpVersionRadio1" value="option1">
                                                        <label class="form-check-label" for="inlineRadio1">HTTP 1.1</label>
                                                    </div>
                                                </div>
                                                <div class="col-sm-4">
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio" name="httpVersionRadio" id="httpVersionRadio1" value="option1">
                                                        <label class="form-check-label" for="inlineRadio1">HTTP 2.0</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <br />
                                            <div class="form-row">
                                                <div class="col-sm-4">
                                                    <label>&nbsp;</label>
                                                </div>
                                                <div class="col-sm-4">
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio" name="httpVersionRadio" id="httpVersionRadio1" value="option1">
                                                        <label class="form-check-label" for="inlineRadio1">HTTP 2 (without 1.1)</label>
                                                    </div>
                                                </div>
                                                <div class="col-sm-4">
                                                    <!-- No option -->
                                                </div>
                                            </div>
                                            <br />
                                            <div class="form-row">
                                                <div class="col-sm-4">
                                                    <label><b>TLS/SSL Version: </b></label>
                                                </div>
                                                <div class="col-sm-4">
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio" name="tlsVersionRadio" id="tlsVersionRadio1" value="option1" checked>
                                                        <label class="form-check-label" for="inlineRadio1">Default</label>
                                                    </div>
                                                </div>
                                                <div class="col-sm-4">
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio" name="tlsVersionRadio" id="tlsVersionRadio1" value="option1">
                                                        <label class="form-check-label" for="inlineRadio1">>= TLSv1</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <br />
                                            <div class="form-row">
                                                <div class="col-sm-4">
                                                    <label>&nbsp;</label>
                                                </div>
                                                <div class="col-sm-4">
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio" name="tlsVersionRadio" id="tlsVersionRadio1" value="option1">
                                                        <label class="form-check-label" for="inlineRadio1">TLSv1.0</label>
                                                    </div>
                                                </div>
                                                <div class="col-sm-4">
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio" name="tlsVersionRadio" id="tlsVersionRadio1" value="option1">
                                                        <label class="form-check-label" for="inlineRadio1">TLSv1.1</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <br />
                                            <div class="form-row">
                                                <div class="col-sm-4">
                                                    <label>&nbsp;</label>
                                                </div>
                                                <div class="col-sm-4">
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio" name="tlsVersionRadio" id="tlsVersionRadio1" value="option1">
                                                        <label class="form-check-label" for="inlineRadio1">TLSv1.2</label>
                                                    </div>
                                                </div>
                                                <div class="col-sm-4">
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio" name="tlsVersionRadio" id="tlsVersionRadio1" value="option1">
                                                        <label class="form-check-label" for="inlineRadio1">TLSv1.3</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <br />
                                            <div class="form-row">
                                                <div class="col-sm-4">
                                                    <label>&nbsp;</label>
                                                </div>
                                                <div class="col-sm-4">
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio" name="tlsVersionRadio" id="tlsVersionRadio1" value="option1">
                                                        <label class="form-check-label" for="inlineRadio1">SSLv2</label>
                                                    </div>
                                                </div>
                                                <div class="col-sm-4">
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio" name="tlsVersionRadio" id="tlsVersionRadio1" value="option1">
                                                        <label class="form-check-label" for="inlineRadio1">SSLv3</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <br />
                                            <div class="form-row">
                                                <div class="col-sm-4">
                                                    <label><b>Execute Using: </b></label>
                                                </div>
                                                <div class="col-sm-4">
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio1" value="option1" checked>
                                                        <label class="form-check-label" for="inlineRadio1">PHP (Server Side)</label>
                                                    </div>
                                                </div>
                                                <div class="col-sm-4">
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio2" value="option2">
                                                        <label class="form-check-label" for="inlineRadio2">JavaScript (Locally) <span class="badge badge-secondary">New</span></label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <br />

                                <!-- Compiled Curl -->
                                <div class="card dark-card">
                                    <h5 class="card-header">
                                        Compiled Curl
                                        <span class="copy-button" id="curl-generated-copy" style="display: none;">
                                            <a href="#___copy" class="btn btn-secondary" onclick="copyTextToClipboard()"><i class="far fa-copy"></i>&nbsp; <span id="copyButtonText">Copy</span></a>
                                        </span>
                                    </h5>
                                    <div class="card-body">
                                        <div class="card" id="curl-generated-empty" style="display: block;">
                                            <h5 class="card-body" style="margin: 0px;">
                                                Provide an address to begin generating the compiled Curl command.
                                            </h5>
                                        </div>
                                        <pre id="curl-generated-wrapper" style="display: none;margin-bottom: 0px;"><code id="curl-generated"></code></pre>
                                    </div>
                                </div>

                                <br />

                                <div class="form-row">
                                    <div class="col-sm-9">
                                        <div class="input-group mb-8">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text"><i class="fas fa-share-square"></i>&nbsp; Share this Curl</div>
                                            </div>
                                            <div class="form-control" id="share-url" onclick="$('#share-url').text('https://curlit.tk/af07g13');">Click to generate URL!</div>
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <a href="#" class="btn btn-primary float-right"><i class="fas fa-paper-plane"></i>&nbsp; Submit Request</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>

                <div class="col-sm-4">
                    <br />

                    <!-- Share -->
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Share</h5>
                            <p class="card-text">Share Curl It! with your friends and colleagues!</p>
                            <div class="float-right">
                                <!-- AddToAny BEGIN -->
                                <div class="a2a_kit a2a_kit_size_32 a2a_default_style">
                                    <a class="a2a_dd" href="https://www.addtoany.com/share"></a>
                                    <a class="a2a_button_facebook"></a>
                                    <a class="a2a_button_twitter"></a>
                                    <a class="a2a_button_email"></a>
                                    <a class="a2a_button_linkedin"></a>
                                </div>
                                <script async src="https://static.addtoany.com/menu/page.js"></script>
                                <!-- AddToAny END -->
                            </div>
                        </div>
                    </div>

                    <br />

                    <!-- Donations -->
                    <div class="card">
                        <img class="card-img-top" src="./assets/images/donate.png" alt="Donate">
                        <div class="card-body">
                            <h5 class="card-title">Donate</h5>
                            <p class="card-text">Donations are welcome! All procedes are put towards maintaining the Curl It! servers.</p>
                            <a href="#" class="btn btn-primary float-right"><i class="fas fa-donate"></i>&nbsp; Donate through PayPal</a>
                        </div>
                    </div>

                    <br />
                </div>
            </div>

            
        </div>

        <!-- Footer -->
        <footer class="page-footer font-small blue">

            <!-- Copyright -->
            <div class="footer-copyright text-center py-3">
                Copyright © 2019, Nathan Fiscaletti
            </div>
            <!-- Copyright -->

            <div align="center">
                <a href="https://github.com/nathan-fiscaletti" target="_blank"><div class='social-icon'><i class="fab fa-github"></i></div></a>
            </div>

        </footer>
        <!-- Footer -->

        <br /><br />

        <!-- Javascript Imports -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/ace/1.4.4/ace.js"></script>
        <script type="text/javascript" src="./assets/jquery/js/jquery-3.4.0.js"></script>
        <script type="text/javascript" src="./assets/bootstrap/js/bootstrap.min.js"></script>
        <script type="text/javascript" src="./assets/js/script.js"></script>
        <script>
            // Set up the ACE editor for the "Payload" section.
            var editor = ace.edit("editor");
            editor.setTheme("ace/theme/chaos");
            editor.session.setMode("ace/mode/javascript");
            editor.setShowPrintMargin(false);
            editor.renderer.setShowGutter(false);
            $(".ace_gutter").css("background", "#202020");

            editor.session.on('change', function(delta) {
                payloadChanged(editor);
            });
        </script>
    </body>
</html>
