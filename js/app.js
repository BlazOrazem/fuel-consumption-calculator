$(document).ready(function() {
    $('.btn-group-toggle > label').click(function() {
        $('.btn-group-toggle > label').removeClass('active');
        $(this).addClass('active');
    });
});

new Vue({
    el: '#fuel',

    data: {
        country: 'Slovenia',
        fuel: 'gasoline',
        distance: '',
        consumption: '',
        resultConsumption: 0,
        resultPriceEur: 0,
        resultPrice: 0,
        currency: 'EUR',
        timer: null
    },

    watch: {
        distance: function () {
            if (this.timer) {
                clearTimeout(this.timer);
                this.timer = null;
            }

            this.timer = setTimeout(() => {
                this.calculate();
            }, 1000);
        },
        consumption: function () {
            if (this.timer) {
                clearTimeout(this.timer);
                this.timer = null;
            }

            this.timer = setTimeout(() => {
                this.calculate();
            }, 1000);
        }
    },

    methods: {
        calculationCanStart: function() {
            return !!(this.country && this.fuel && this.distance && this.consumption);
        },
        calculate: function() {
            if (!this.calculationCanStart()) {
                return null;
            }

            loading.start();

            axios
                .get('fuel.php?country=' + this.country + '&fuel=' + this.fuel)
                .then(response => {
                    this.resultConsumption = this.calculateConsumption(),
                    this.resultPriceEur = this.calculatePrice(response.data.default.price),
                    this.resultPrice = this.calculatePrice(response.data.regional.price),
                    this.currency = response.data.regional.currency,
                    loading.stop()
                })
                .catch(error => {
                    loading.stop(),
                    console.log(error)
                });
        },
        calculateConsumption: function() {
            let distance = parseFloat(this.distance.replace(',','.'));
            let consumption = parseFloat(this.consumption.replace(',','.'));

            return parseFloat(distance * consumption / 100).toFixed(2);
        },
        calculatePrice: function(price) {
            return parseFloat(this.calculateConsumption() * price).toFixed(2);
        }
    }
});

var loading = {
    start: function() {
        $('<div class="loading"></div>').appendTo('body').show();
    },
    stop: function() {
        if ($('.loading').length) $('.loading').hide();
    }
};
