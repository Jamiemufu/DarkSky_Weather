<template>
    <div>
        <div class="daily-container">
            <!-- loop through days and set component for each day-->
            <div v-for="item in daily">
                <daily :daily="item" :icon="item['icon']" :summary="item['summary']" @clicked="onClickChild"></daily>
            </div>
        </div>
        <div class="selected-container">
            <div class="current-container text-center">
                <div class="card-header">
                    <h5>{{ getDay(date) }} - {{ convertDate(date) }}</h5>
                    <h5>
                        <span class="location">details for {{ location }}</span>
                    </h5>
                </div>
                <div class="card">
                    <div>
                        <canvas :id="currentIcon" width="150" height="150"></canvas>
                        <br>
                        <transition name="fade">
                            <div v-if="show">
                                <h3 v-if="show">{{ summary }}</h3>
                            </div>
                        </transition>
                    </div>
                    <transition name="fade">
                        <div class="current-details" v-if="show">
                            <!-- get all items from daily component -->
                            <div v-for="item, index in child" :key="index">
                                <!-- hide icon/time item -->
                                <div v-if="index == 'icon' || index == 'time' || index == 'summary'"></div>
                                <div v-else>
                                    <div class="item">
                                        <i v-html="getIcons(index)"></i>
                                        {{index}}<br>{{item}}
                                    </div>
                                </div>
                            </div>
                            <!-- end of items -->
                        </div>
                        <!-- end current details -->
                    </transition>
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
        props: [
            "daily", "icon", "location"
        ],
        data: function () {
            // store store data from child components
            return {
                child: '',
                show: true,
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
                return 'icon' + this.icon;
            },
            currentLocation() {
                return this.location;
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
            // set id and icon
            skycons.add("icon" + this.icon, this.icon);
            skycons.play();
            //get today for the mounted dataset
            this.child = this.daily[0]
        },
        methods: {
            //switch statements for all icons we need
            toggleShow() {
                this.isShowing = !this.isShowing;
            },
            getIcons(index) {
                switch (index) {
                    case 'precipProbability':
                        return "<i class='las la-tint' style='color: lightblue !important;'></i> <br />"
                        break;
                    case 'temperatureHigh':
                        return "<i class='las la-thermometer-full' style='color: red !important;'></i> <br />"
                        break;
                    case 'temperatureLow':
                        return "<i class='las la-thermometer-empty' style='color: lightblue !important;'></i> <br />"
                        break;
                    case 'visibility':
                        return "<i class='las la-smog' style='color: lightgrey !important;'></i> <br />"
                        break;
                    case 'windSpeed':
                        return "<i class='las la-wind' style='color: grey !important;'></i> <br />"
                        break;
                    case 'cloudCover':
                        return "<i class='las la-cloud' style='color: grey !important;'></i> <br />"
                        break;
                    case 'sunriseTime':
                        return "<i class='las la-sun' style='color: orange !important;'></i> <br />"
                        break;
                    case 'sunsetTime':
                        return "<i class='las la-cloud-sun' style='color: brown !important;'></i> <br />"
                        break;
                    case 'moonPhase':
                        return "<i class='las la-moon' style='color:silver !important;'></i> <br />"
                        break;
                    case 'pressure':
                        return "<i class='las la-exchange-alt' style='color: blue !important;'></i> <br />"
                        break;
                    case 'humidity':
                        return "<i class='las la-water' style='color: lightblue !important;'></i> <br />"
                        break;
                    case 'uvIndex':
                        return "<i class='las la-glasses' style='color: red !important;'></i> <br />"
                        break;
                    default:
                        break;
                }
            },
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
                this.show = !this.show;
                setTimeout(() => {
                    this.show = !this.show;
                    skycons.set("icon" + this.icon, this.child.icon);
                    skycons.play();
                }, 500);
                
            },
            //unix timestamp functions
            convertDate(time) {
                var a = new Date(time * 1000);
                    var months = ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'];
                    var year = a.getFullYear();
                    var month = months[a.getMonth()];
                    var date = a.getDate();
                    var formattedTime = date + ' ' + month + ' ' + year;
                    return formattedTime;
            },
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
