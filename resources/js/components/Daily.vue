<template>
    <div class="day-container text-center">
        <div class="card-header">
            <!-- get day and day for the day -->
            <h5>
                <span>{{ getDay(time) }} {{ convertDate(time) }}</span>
            </h5>
        </div>
        <div class="card" @click="update">
            <!-- get icon -->
            <canvas :id="'icon' + this.daily.time" width="60" height="60"></canvas>
            <p class="more-info">more</p>
            <i class="las la-caret-down"></i>
        </div>
    </div>
</template>

<script>
export default {
    props: ["daily", "icon"],
    computed: {
        time() {
            return this.daily.time;
        },
    },
    mounted() {
        //get and set icon
        //main, moon, fog, fogbank, light_cloud, cloud, dark_cloud,
        // thunder, snow, hail, sleet, wind, leaf, rain, sun
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
            "precipIntensity",
            "precipIntensityMax",
            "precipIntensityMaxTime",
            "precipType",
            "temperatureHighTime",
            "temperatureLowTime",
            "apparentTemperatureHigh",
            "apparentTemperatureHighTime",
            "apparentTemperatureLow",
            "apparentTemperatureLowTime",
            "dewPoint",
            "windGust",
            "windGustTime",
            "windBearing",
            "uvIndexTime",
            "ozone",
            "temperatureMin",
            "temperatureMinTime",
            "temperatureMax",
            "temperatureMaxTime",
            "apparentTemperatureMin",
            "apparentTemperatureMinTime",
            "apparentTemperatureMax",
            "apparentTemperatureMaxTime"
        ];

        list.forEach(element => {
            this.$delete(this.daily, element)
        });
    },
    methods: {
        getDay(time) {
            //from Current
            return this.$parent.getDay(time);
        },
        convertDate(time) {
            return this.$parent.convertDate(time);
        },
        update (event) {
            this.$emit('clicked', this.daily);
        }
    }
};
</script>
