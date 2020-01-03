<template>
    <div>
        <div class="daily-container">
            <!-- loop through days -->
            <div v-for="item in daily">
                <daily :daily="item" :icon="item['icon']" :summary="item['summary']" @clicked="onClickChild">
                </daily>
            </div>
        </div>
        <div class="selected-container">
            <div class="current-container text-center">
                <div class="card-header">
                    <h5>
                        <span>{{ getDay(date) }}</span>
                    </h5>
                </div>
                <div class="card">

                    <div class="card-summary">
                        <canvas :id="currentIcon" width="150" height="150"></canvas>
                        <br>
                        <h3><span>{{ summary }}</span></h3>
                    </div>

                    <div class="current-details">

                        <div class="item">
                            <i class="las la-tint" style="color: lightblue !important;"></i> <br />
                            {{ rainChance[0] }} <br />
                            <span>{{ rainChance[1] }}</span>
                        </div>

                        <div class="item">
                            <i class="las la-thermometer-full" style="color: red !important;"></i> <br />
                            {{ temperatureHigh[0] }} <br />
                            <span>{{ temperatureHigh[1] }}</span>
                        </div>

                        <div class="item">
                            <i class="las la-thermometer-empty" style="color: lightblue !important;"></i> <br />
                            {{ temperatureLow[0] }} <br />
                            <span>{{ temperatureLow[1] }}</span>
                        </div>

                        <div class="item">
                            <i class="las la-smog" style="color: grey !important;"></i> <br />
                            {{ visibility[0] }} <br />
                            <span>{{ visibility[1] }}</span>
                        </div>

                        <div class="item">
                            <i class="las la-wind" style="color: grey !important;"></i> <br />
                            {{ windSpeed[0] }} <br />
                            <span>{{ windSpeed[1] }}</span>
                        </div>

                        <div class="item">
                            <i class="las la-cloud" style="color: grey !important;"></i> <br />
                            {{ cloudCover[0] }} <br />
                            <span>{{ cloudCover[1] }}</span>
                        </div>

                        <div class="item">
                            <i class="lar la-sun" style="color: orange !important;"></i> <br />
                            {{ sunriseTime[0] }} <br />
                            <span>{{ convertTime(sunriseTime[1]) }}</span>
                        </div>

                        <div class="item">
                            <i class="las la-cloud-sun" style="color: maroon !important;"></i> <br />
                            {{ sunsetTime[0] }} <br />
                            <span>{{ convertTime(sunsetTime[1]) }}</span>
                        </div>

                        <div class="item">
                            <i class="las la-moon" style="color: silver !important;"></i> <br />
                            {{ moonPhase[0] }} <br />
                            <span>{{ moonPhase[1] }}</span>
                        </div>

                        <div class="item">
                            <i class="las la-exchange-alt" style="color: blue !important;"></i> <br />
                            {{ pressure[0] }} <br />
                            <span>{{ pressure[1] }}</span>
                        </div>

                        <div class="item">
                            <i class="las la-water" style="color: lightblue !important;"></i> <br />
                            {{ humidity[0] }} <br />
                            <span>{{ humidity[1] }}</span>
                        </div>

                        <div class="item">
                            <i class="las la-glasses" style="color: red !important;"></i> <br />
                            {{ uvIndex[0] }} <br />
                            <span>{{ uvIndex[1] }}</span>
                        </div>
                        <!-- end of items -->
                    </div>
                    <!-- end current details -->
                </div>
                <!-- end card -->
            </div>
            <!-- end current-container -->
        </div>
        <!-- end selected container -->
    </div>
</template>

<script>
    export default {
        props: ["daily"],
        data: function () {
            // store store data from child components
            return {
                child: ''
            }
        },
        computed: {
            // all the properties we want from reponse
            summary() {
                return this.child.summary;
            },
            date() {
                return this.child.time;
            },
            currentIcon() {
                return 'icon' + this.daily[0].icon;
            },
            rainChance() {
                let arr = ["Rain Chance"];
                arr.push(this.child.precipProbability);
                return arr;
            },
            temperatureHigh() {
                let arr = ["High Temperature"];
                arr.push(this.child.temperatureHigh + "°C");
                return arr;
            },
            temperatureLow() {
                let arr = ["Low Temperature"];
                arr.push(this.child.temperatureLow + "°C");
                return arr;
            },
            visibility() {
                let arr = ["Visibility"];
                arr.push(this.child.visibility);
                return arr;
            },
            windSpeed() {
                let arr = ["Wind Speed"];
                arr.push(this.child.windSpeed);
                return arr;
            },
            cloudCover() {
                let arr = ["Cloud Cover"];
                arr.push(this.child.cloudCover);
                return arr;
            },
            sunriseTime() {
                let arr = ["Sunrise Time"];
                arr.push(this.child.sunriseTime);
                return arr;
            },
            sunsetTime() {
                let arr = ["Sunset Time"];
                arr.push(this.child.sunsetTime);
                return arr;
            },
            moonPhase() {
                let arr = ["Moon Phase"];
                arr.push(this.child.moonPhase);
                return arr;
            },
            pressure() {
                let arr = ["Pressure"];
                arr.push(this.child.pressure);
                return arr;
            },
            humidity() {
                let arr = ["Humidity"];
                arr.push(this.child.humidity);
                return arr;
            },
            uvIndex() {
                let arr = ["UV Index"];
                arr.push(this.child.uvIndex);
                return arr;
            },
        },
        mounted() {
            // mount the first icon
            var skycons = new Skycons({
                monochrome: false,
                color: {
                    cloud: "#F00",
                    wind: "#F00"
                }
            });
            skycons.add("icon" + this.daily[0].icon, Skycons.PARTLY_CLOUDY_NIGHT);
            skycons.play();
            this.child = this.daily[0]
        },
        methods: {
            // data being passed back from child
            onClickChild(value) {
                this.child = value;
                //re-set icon
                var skycons = new Skycons({
                    monochrome: false,
                    color: {
                        cloud: "#F00",
                        wind: "#F00"
                    }
                });
                skycons.set("icon" + this.daily[0].icon, this.child.icon);
                skycons.play();
            },
            //unix timestamp functions
            getDay(time) {
                var origDate = new Date(time * 1000);
                var days = [
                    "Sunday",
                    "Monday",
                    "Tuesday",
                    "Wednesday",
                    "Thursday",
                    "Friday",
                    "Saturday"
                ];
                var day = days[origDate.getDay()];
                var formattedDate = day;
                return formattedDate;
            },
            convertTime(time) {
                var origDate = new Date(time * 1000);
                var hours = "0" + origDate.getHours();
                var minutes = "0" + origDate.getMinutes();
                var seconds = "0" + origDate.getSeconds();
                var formattedTime = hours.substr(-2) + ':' + minutes.substr(-2) + ':' + seconds.substr(-2);
                return formattedTime;
            },
        }
    };

</script>

<style scoped>
    canvas {
        width: 150px;
        height: 150px;
    }

</style>
