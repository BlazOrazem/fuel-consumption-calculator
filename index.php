<!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="UTF-8">
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no">
    <meta name="description" content="Easily calculate fuel travel expenses in different countries based on the latest fuel prices.">
    <meta name="keywords" content="fuel, consumption, calculator">
    <meta name="author" content="Blaž Oražem">

    <title>Fuel Consumption Calculator</title>

    <link rel="shortcut icon" href="images/favicon.png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<div class="color-overlay"></div>

<div class="container">
    <header>
        <h1 class="font-weight-bold">Fuel Consumption Calculator</h1>
        <p class="lead pt-2">Calculate your fuel travel expenses easily.</p>
    </header>
</div>

<div id="fuel" class="container">
    <div class="row justify-content-lg-center pt-3">
        <div class="col col-lg-6">
            <div class="form-group row results">
                <div class="col col-sm-6 col-xs-12">
                    <div class="row">
                        <label for="inputCountry" class="col-4 col-form-label text-right font-weight-bold">
                            Country
                        </label>
                        <div class="col-8">
                            <select class="form-control" id="inputCountry" v-model="country" v-on:change="calculate()">
                                <option value="Austria">Austria</option>
                                <option value="Bosnia-and-Herzegovina">Bosnia and Herzegovina</option>
                                <option value="Croatia">Croatia</option>
                                <option value="Germany">Germany</option>
                                <option value="Hungary">Hungary</option>
                                <option value="Italy">Italy</option>
                                <option value="Slovenia" selected>Slovenia</option>
                                <option value="Serbia">Serbia</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-xs-12 btn-group btn-group-toggle">
                    <label class="btn btn-info active" data-fuel="gasoline">
                        <input type="radio" name="fuel" autocomplete="off" value="gasoline" v-model="fuel" v-on:change="calculate()" checked> Gasoline
                    </label>
                    <label class="btn btn-info" data-fuel="diesel">
                        <input type="radio" name="fuel" autocomplete="off" value="diesel" v-model="fuel" v-on:change="calculate()"> Diesel
                    </label>
                    <label class="btn btn-info" data-fuel="lpg">
                        <input type="radio" name="fuel" autocomplete="off" value="lpg" v-model="fuel" v-on:change="calculate()"> LPG
                    </label>
                </div>
            </div>
        </div>
    </div>
    <div class="row justify-content-lg-center small-hide pt-2">
        <div class="col col-lg-3">
            <label for="inputDistance" class="control-label font-weight-bold">Distance <small>(km)</small></label>
            <input type="text" class="form-control" id="inputDistance" placeholder="enter distance, eg. 125,5" v-model="distance">
        </div>
        <div class="col col-lg-3">
            <label for="inputConsumption" class="control-label font-weight-bold">Avg. consumption <small>(L/100km)</small></label>
            <input type="text" class="form-control" id="inputConsumption" placeholder="enter consumption, eg. 7,4" v-model="consumption">
        </div>
    </div>
    <div class="row justify-content-lg-center pt-3">
        <div class="col col-lg-6">
            <p class="text-center mb-0">
                <small>
                    Fuel prices are parsed from <a href="https://www.globalpetrolprices.com" target="_blank">globalpetrolprices.com</a>.
                </small>
            </p>
        </div>
    </div>
    <div class="row justify-content-lg-center">
        <div class="col col-lg-6">
            <hr>
        </div>
    </div>
    <div class="row justify-content-lg-center pt-3">
        <div class="col col-lg-6">
            <div class="form-group row results">
                <label for="calculatedConsumption" class="col-4 col-form-label text-right font-weight-bold">
                    Consumption
                </label>
                <div class="col-6">
                    <input type="text" class="form-control text-right" id="calculatedConsumption" v-model="resultConsumption" readonly>
                </div>
                <label class="col-2 col-form-label font-weight-bold">L</label>
            </div>
            <div class="form-group row results">
                <label for="calculatedPriceEur" class="col-4 col-form-label text-right font-weight-bold">
                    Price
                </label>
                <div class="col-6">
                    <input type="text" class="form-control text-right" id="calculatedPriceEur" v-model="resultPriceEur" readonly>
                </div>
                <label class="col-2 col-form-label font-weight-bold">EUR</label>
            </div>
            <div class="form-group row results mb-3">
                <label for="calculatedPrice" class="col-4 col-form-label text-right font-weight-bold">
                    Price <small>(regional)</small>
                </label>
                <div class="col-6">
                    <input type="text" class="form-control text-right" id="calculatedPrice" v-model="resultPrice" readonly>
                </div>
                <label class="col-2 col-form-label font-weight-bold">{{ currency }}</label>
            </div>
        </div>
    </div>
    <div class="row justify-content-lg-center">
        <div class="col col-lg-6">
            <hr>
        </div>
    </div>
</div>

<footer>
    <p class="text-center">
        &copy; <a href="https://www.orazem.si" target="_blank">Orazem.si</a> <?= date('Y') ?>. All rights reserved.
    </p>
    <p class="text-center">
        <i class="github-icon"></i>
        <a href="https://github.com/BlazOrazem/fuel-consumption-calculator" target="_blank">
            Fuel Consumption Calculator on Github.
        </a>
    </p>
</footer>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/vue/2.6.10/vue.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.19.0/axios.min.js"></script>
<script src="js/app.js"></script>

</body>
</html>