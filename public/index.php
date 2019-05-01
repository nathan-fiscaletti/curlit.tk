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
                    <h1 class="display-4">CurlIt!</h1>
                    <p class="lead">CurlIt! allows you to send HTTP requests from within your browser using either PHP or JavaScript! Try it out below!</p>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-8">
                    <!-- Main Form -->
                    <br />
                    <form>
                        <!-- Request -->
                        <div class="card">
                            <h5 class="card-header">Request</h5>
                            <div class="card-body">
                                <div class="form-row">
                                    <div class="col-sm-8">
                                        <div class="input-group mb-8">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text"><i class="fas fa-globe-americas"></i></div>
                                            </div>
                                            <input type="text" class="form-control" placeholder="Address..." />
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <select class="form-control">
                                            <option selected>GET</option>
                                            <option>POST</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <br />
                        
                        
                        <!-- Headers -->
                        <div class="card">
                            <h5 class="card-header pointer-cursor" id="headersHeading" data-toggle="collapse" data-target="#headersBody" aria-expanded="true" aria-controls="headersBody">
                                Headers
                                <span class="section-dd">
                                    <i class="fas fa-chevron-down"></i>
                                </span>
                            </h5>
                            <div id="headersBody" class="collapse">
                                <div class="card-body">
                                    <div class="form-row">
                                        <div class="col-sm-12">
                                            <table class="table table-bordered">
                                                <thead>
                                                    <tr>
                                                    <th scope="col">Header</th>
                                                    <th scope="col">Value</th>
                                                    <th scope="col"></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <th scope="row">Content-Type</th>
                                                        <td><code>application/json</code></td>
                                                        <td style="width: 1%; white-space: nowrap;"><a href="#" class="btn btn-danger"><i class="fas fa-trash-alt"></i></a></td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                            <hr />
                                            <div class="form-row">
                                                <div class="col-sm-5">
                                                    <div class="input-group mb-8">
                                                        <div class="input-group-prepend">
                                                            <div class="input-group-text"><i class="fas fa-heading"></i></div>
                                                        </div>
                                                        <input type="text" class="form-control" placeholder="Header..." />
                                                    </div>
                                                </div>
                                                <div class="col-sm-5">
                                                    <input type="text" class="form-control" placeholder="Value..." />
                                                </div>
                                                <div class="col-sm-2">
                                                    <a href="#" class="btn btn-info float-right full-w-button"><i class="fas fa-plus-circle"></i>&nbsp; Add</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <br />

                        <!-- Options -->
                        <div class="card">
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
                                                <input class="form-check-input" type="checkbox" id="inlineCheckbox1" value="option1">
                                                <label class="form-check-label" for="inlineCheckbox1">Insecure (<code>-k</code>)</label>
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <!-- Other option -->
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
                        <div class="card">
                            <h5 class="card-header">Compiled Curl</h5>
                            <div class="card-body">
<pre><code>curl -k \
     -H'Content-Type: application/json' \
     'https://api.curlit.tk/ip'
</code></pre>
                            </div>
                        </div>

                        <br />

                        <div class="form-row">
                            <div class="col-sm-7">
                                <div class="input-group mb-8">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text"><i class="fas fa-share-square"></i>&nbsp; Share this Curl</div>
                                    </div>
                                    <input type="text" class="form-control" disabled value="https://curlit.tk/ac33c177" />
                                </div>
                            </div>
                            <div class="col-sm-5">
                                <a href="#" class="btn btn-primary float-right"><i class="fas fa-paper-plane"></i>&nbsp; Submit</a>
                            </div>
                        </div>

                        <br /><br />
                    </form>
                </div>

                <div class="col-sm-4">
                    <br />

                    <!-- Share -->
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Share</h5>
                            <p class="card-text">Share Curl It! with your friends and coleagues!</p>
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
                            <p class="card-text">Donations are welcome! Donations are put towards maintaining the Curl It! servers.</p>
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
            <div class="footer-copyright text-center py-3">© Copyright 2019, 
                <a href="https://github.com/nathan-fiscaletti/" target="_blank"> Nathan Fiscaletti</a>
            </div>
            <!-- Copyright -->

        </footer>
        <!-- Footer -->

        <!-- Javascript Imports -->
        <script type="text/javascript" src="./assets/jquery/js/jquery-3.4.0.js"></script>
        <script type="text/javascript" src="./assets/bootstrap/js/bootstrap.min.js"></script>
    </body>
</html>