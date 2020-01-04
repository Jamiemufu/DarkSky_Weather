<template>
    <div class="day-container text-center">
        <div class="card-header">
            <!-- get day and day for the day -->
            <h5>
                <span>{{ getDay(time) }}</span>
            </h5>
        </div>
        <div class="card">
            <!-- get icon -->
            <canvas :id="'icon' + this.daily.time" width="40" height="40"></canvas>
            <i @click="update" class="las la-caret-down"></i>
        </div>
    </div>
</template>

<script>
export default {
    props: ["daily", "icon", "summary"],
    computed: {
        time() {
            return this.daily.time;
        },
    },
    mounted() {
        //get and set icon
        //main, moon, fog, fogbank, light_cloud, cloud, dark_cloud,
        // thunder, snow, hail, sleet, wind, leaf, rain, sun
        var currentIcon = this.icon
        var skycons = new Skycons({
            monochrome: false,
            color: {
                cloud: "#F00",
                wind: "#F00"
            }
        });
        skycons.add("icon" + this.daily.time, this.icon);
        skycons.play();

        // list of properties to remove that we don't need
        var list = [
            "time","summary", "precipIntensity", "precipIntensityMax", "precipIntensityMaxTime", "precipType", "temperatureHighTime", "temperatureLowTime", "apparentTemperatureHigh", "apparentTemperatureHighTime", "apparentTemperatureLow", "apparentTemperatureLowTime", "dewPoint", "windGust", "windGustTime", "windBearing", "uvIndexTime", "ozone", "temperatureMin", "temperatureMinTime", "temperatureMax", "temperatureMaxTime", "apparentTemperatureMin", "apparentTemperatureMinTime", "apparentTemperatureMax", "apparentTemperatureMaxTime"
        ]

        list.forEach(element => {
            this.$delete(this.daily, element)
        });
    },
    methods: {
        getDay(time) {
            //from Current
            return this.$parent.getDay(time);
        },
        update (event) {
            this.$emit('clicked', this.daily);
        }
    }
};
</script>
