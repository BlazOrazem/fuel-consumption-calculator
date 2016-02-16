<!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="UTF-8">
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no"/>
    <meta name="description" content="Calculate your travel expenses with Fuel Consumption Calculator."/>
    <meta name="keywords" content="fuel, consumption, calculator">
    <meta name="author" content="Blaž Oražem">

    <title>Fuel Consumption Calculator</title>

    <link rel="shortcut icon" href="images/fuel.png">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/bootstrap-switch.min.css">
    <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,700,600,400italic&subset=latin,latin-ext' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="css/styles.css" />

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body>

<div class="color-overlay"></div>

<div class="container">
    <header>
        <h1>Fuel Consumption Calculator</h1>
        <p class="lead">Calculate your travel expenses.</p>
    </header>
    <div id="fuel" class="row">
        <div class="col col-md-6 col-md-offset-3">
            <form class="form-horizontal">
                <div class="form-group deviate-bottom-none">
                    <label for="inputCountry" class="control-label col-sm-2">Country</label>
                    <div class="col-sm-10">
                        <select class="form-control" id="inputCountry" v-model="country">
                            <?php foreach(getPriceList() as $key => $country): ?>
                                <option value="<?php echo($key); ?>" <?php if($key == 'Slovenia'): echo('selected'); endif; ?>>
                                    <?php echo($key); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-xs-12"><hr></div>
                </div>
                <div class="form-group">
                    <div class="col col-md-6">
                        <label for="inputDistance" class="control-label">Distance (km)</label>
                        <input type="text" class="form-control deviate-top" id="inputDistance" v-model="distance">
                    </div>
                    <div class="col col-md-6">
                        <label for="inputConsumption" class="control-label avg-consumption">Avg. consumption (L/100km)</label>
                        <input type="text" class="form-control deviate-top" id="inputConsumption" v-model="consumption">
                    </div>
                </div>
                <div class="form-group text-center">
                    <div class="btn-group deviate-top fuel-type">
                        <button type="button" data-switch-set="size" data-switch-value="95" data-fuel="95" class="btn btn-default active">Normal 95</button>
                        <button type="button" data-switch-set="size" data-switch-value="98" data-fuel="98" class="btn btn-default">Normal 98</button>
                        <button type="button" data-switch-set="size" data-switch-value="100" data-fuel="100" class="btn btn-default">Super 100</button>
                        <button type="button" data-switch-set="size" data-switch-value="diesel" data-fuel="diesel" class="btn btn-default">Diesel</button>
                        <button type="button" data-switch-set="size" data-switch-value="lpg" data-fuel="lpg" class="btn btn-default">LPG</button>
                    </div>
                    <div class="btn-group hidden">
                        <input type="radio" name="fuel" v-model="fuel" class="fuel-type" value="95" checked>
                        <input type="radio" name="fuel" v-model="fuel" class="fuel-type" value="98">
                        <input type="radio" name="fuel" v-model="fuel" class="fuel-type" value="100">
                        <input type="radio" name="fuel" v-model="fuel" class="fuel-type" value="diesel">
                        <input type="radio" name="fuel" v-model="fuel" class="fuel-type" value="lpg">
                    </div>
                    <div class="col-xs-12 deviate-top"><hr></div>
                </div>
                <div class="form-group">
                    <label for="inputComputedConsumption" class="control-label text-left col-md-3 col-sm-3 col-xs-5">Consumption</label>
                    <div class="col-md-7 col-sm-7 col-xs-5">
                        <input type="text" class="form-control" id="inputComputedConsumption" v-model="resultDistance">
                    </div>
                    <label class="control-label text-left col-md-2 col-sm-2 col-xs-2">L</label>
                </div>
                <div class="form-group">
                    <label for="inputComputedPrice" class="control-label text-left col-md-3 col-sm-3 col-xs-5">Price</label>
                    <div class="col-md-7 col-sm-7 col-xs-5">
                        <input type="text" class="form-control" id="inputComputedPrice" v-model="resultPrice">
                    </div>
                    <label class="control-label text-left col-md-2 col-sm-2 col-xs-2">{{ currency }}</label>
                </div>
                <div class="form-group">
                    <label for="inputComputedPriceEur" class="control-label text-left col-md-3 col-sm-3 col-xs-5">Price</label>
                    <div class="col-md-7 col-sm-7 col-xs-5">
                        <input type="text" class="form-control" id="inputComputedPriceEur" v-model="resultPriceEur">
                    </div>
                    <label class="control-label text-left col-md-2 col-sm-2 col-xs-2">EUR</label>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="js/vue.js"></script>
<script src="js/jquery.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/bootstrap-switch.min.js"></script>
<script src="js/app.js"></script>

<script>
    new Vue({
        el: '#fuel',

        data: {
            country: '',
            distance: '',
            consumption: '',
            fuel: '',
            resultDistance: '',
            resultPrice: '',
            resultPriceEur: '',
            currency: 'EUR'
        },

        computed: {
            resultDistance: function() {
                var distance = parseFloat(this.distance.replace(',','.'));
                var consumption = parseFloat(this.consumption.replace(',','.'));

                return distance * consumption / 100;
            },
            resultPrice: function() {
                var priceList = <?php echo(getPriceList(true)); ?>;

                var price = 0;

                if (this.fuel == '95') {
                    price = priceList[this.country]['fuelType']['95'];
                }
                if (this.fuel == '98') {
                    price = priceList[this.country]['fuelType']['98'];
                }
                if (this.fuel == '100') {
                    price = priceList[this.country]['fuelType']['100'];
                }
                if (this.fuel == 'diesel') {
                    price = priceList[this.country]['fuelType']['diesel'];
                }
                if (this.fuel == 'lpg') {
                    price = priceList[this.country]['fuelType']['lpg'];
                }

                this.currency = priceList[this.country]['currency'];

                return this.resultDistance * price;
            },
            resultPriceEur: function() {
                var conversion = 1;

                if (this.currency == 'HRK') {
                    conversion = 7.62169458;
                }
                if (this.currency == 'RSD') {
                    conversion = 122.223858;
                }
                if (this.currency == 'KM') {
                    conversion = 1.95583;
                }

                return this.resultPrice / conversion;
            }
        }
    });
</script>

<?php
    function getPriceList($json = false)
    {
        $priceList = array();
        $xml = simplexml_load_file('http://www.petrol.eu/api/fuel_prices.xml');

        foreach ($xml as $item) {
            $country = (string)$item->attributes()->label;
            if ($country == 'Kosovo') {
                continue;
            }
            $priceList[$country] = array();
            foreach ($item->fuel as $fuel) {
                $fuelType = (string)$fuel->attributes()->type;
                $priceList[$country]['currency'] = (string)$fuel->priceType->price->attributes()->currency;
                $priceList[$country]['updated'] = (string)$fuel->priceType->attributes()->updated;
                $priceList[$country]['fuelType'][$fuelType] = (string)$fuel->priceType->price;
            }
        }

        return $json ? json_encode($priceList) : $priceList;
    }
?>

</body>
</html>