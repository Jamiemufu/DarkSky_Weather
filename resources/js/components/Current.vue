<template>
    <div class="main card">
        <!-- main card header -->
        <div class="card-header">
            <div>Weather Forcast</div>
            <div class="search">
                <!-- search form -->
                <form @submit="search">
                    <button type="submit">
                        <i class="las la-search"></i>
                    </button>
                    <input type="text" placeholder="search" v-model="location" />
                </form>
            </div>
        </div>
        <!-- daily component cards -->
        <div class="daily-container">
            <!-- loop through days and set component for each day-->
            <div v-for="item in daily">
                <daily :daily="item" :icon="item['icon']" :summary="item['summary']" :key="componentKey"
                    @clicked="onClickChild">
                </daily>
            </div>
        </div>
        <!-- more info container -->
        <div class="selected-container">
            <div class="current-container text-center">
                <!-- selected card header -->
                <div class="card-header">
                    <h5>{{ getDay(date) }} - {{ convertDate(date) }}</h5>
                    <h5> Details for {{ location }}</h5>
                </div>
                <!-- selected card content -->
                <div class="card">
                    <!-- icon and summary -->
                    <div class="icon">
                        {{ getIcon() }}
                        <canvas :id="currentIcon" width="150" height="150"></canvas>
                        <transition name="fade">
                            <div v-if="show">
                                <h3> {{ summary }}</h3>
                            </div>
                        </transition>
                    </div>
                    <!-- details with fade -->
                    <transition name="fade">
                        <div class="current-details" v-if="show">
                            <!-- get all items from daily component -->
                            <div v-for="item, index in child" :key="index">
                                <!-- hide icon/time item -->
                                <div v-if="index == 'icon' || index == 'time' || index == 'summary'"></div>
                                <div v-else>
                                    <!-- each item -->
                                    <div class="item" v-if="index == 'sunriseTime' || index == 'sunsetTime'">
                                        <i v-html="getIcons(index)"></i>
                                        {{index}}
                                        <br />
                                        {{convertTime(item)}}
                                    </div>
                                    <div v-else class="item">
                                        <i v-html="getIcons(index)"></i>
                                        {{index}}
                                        <br />
                                        {{item}}
                                    </div>
                                </div>
                            </div>
                            <!-- end of items -->
                        </div>
                        <!-- end current details -->
                    </transition>
                </div>
                <!-- end selected card content -->
            </div>
            <!-- end current card-container -->
        </div>
        <!-- end selected card -->
    </div>
    <!-- end main card -->
</template>

<script>
    export default {
        props: [],
        data() {
            // data for storage or child props
            return {
                child: '',
                show: true,
                daily: '',
                icon: '',
                location: '',
                componentKey: 0,
            };
        },
        created() {
            axios.get('/forecast')
                .then(response => {
                    // repsonse contains location[1] and forecast[0]
                    // get location
                    this.location = response.data[1];
                    // get daily forecast and store for filtering
                    this.daily = response.data[0].data;
                    // assign today to child for first render
                    this.child = this.daily[0];
                    // set icon
                    this.icon = this.child['icon'];
                })
        },
        computed: {
            summary() {
                return this.child.summary;
            },
            date() {
                return this.child.time;
            },
            currentIcon() {
                return "icon" + this.icon;
            },
            currentLocation() {
                return this.daily;
            },
        },
        mounted() {

        },
        methods: {
            // fade toggle
            toggleShow() {
                this.isShowing = !this.isShowing;
            },
            //switch statements for all icons we need
            getIcons(index) {
                switch (index) {
                    case "precipProbability":
                        return "<i class='las la-tint' style='color: lightblue !important;'></i> <br />";
                        break;
                    case "temperatureHigh":
                        return "<i class='las la-thermometer-full' style='color: red !important;'></i> <br />";
                        break;
                    case "temperatureLow":
                        return "<i class='las la-thermometer-empty' style='color: lightblue !important;'></i> <br />";
                        break;
                    case "visibility":
                        return "<i class='las la-smog' style='color: lightgrey !important;'></i> <br />";
                        break;
                    case "windSpeed":
                        return "<i class='las la-wind' style='color: grey !important;'></i> <br />";
                        break;
                    case "cloudCover":
                        return "<i class='las la-cloud' style='color: grey !important;'></i> <br />";
                        break;
                    case "sunriseTime":
                        return "<i class='las la-sun' style='color: orange !important;'></i> <br />";
                        break;
                    case "sunsetTime":
                        return "<i class='las la-cloud-sun' style='color: brown !important;'></i> <br />";
                        break;
                    case "moonPhase":
                        return "<i class='las la-moon' style='color:silver !important;'></i> <br />";
                        break;
                    case "pressure":
                        return "<i class='las la-exchange-alt' style='color: blue !important;'></i> <br />";
                        break;
                    case "humidity":
                        return "<i class='las la-water' style='color: lightblue !important;'></i> <br />";
                        break;
                    case "uvIndex":
                        return "<i class='las la-glasses' style='color: red !important;'></i> <br />";
                        break;
                    default:
                        break;
                }
            },
            // data being passed back from child
            onClickChild(value) {
                this.child = value;
                this.show = !this.show;
                this.icon = this.child.icon;
                setTimeout(() => {
                    this.show = !this.show;

                }, 500);
            },
            //unix timestamp functions
            convertDate(time) {
                var a = new Date(time * 1000);
                var months = [
                    "Jan",
                    "Feb",
                    "Mar",
                    "Apr",
                    "May",
                    "Jun",
                    "Jul",
                    "Aug",
                    "Sep",
                    "Oct",
                    "Nov",
                    "Dec"
                ];
                var year = a.getFullYear();
                var month = months[a.getMonth()];
                var date = a.getDate();
                var formattedTime = date + " " + month + " " + year;
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
                var formattedTime =
                    hours.substr(-2) + ":" + minutes.substr(-2) + ":" + seconds.substr(-2);
                return formattedTime;
            },
            // get and update icons
            getIcon() {
                var skycons = new Skycons({
                    monochrome: false,
                    color: {
                        cloud: "#F00",
                        wind: "#F00"
                    }
                });
                skycons.add("icon" + this.icon, this.icon);
                skycons.play();
            },
            updateIcon() {
                var skycons = new Skycons({
                    monochrome: false,
                    color: {
                        cloud: "#F00",
                        wind: "#F00"
                    }
                });
                skycons.set("icon" + this.child.icon, this.icon);
                skycons.play();
            },
            search(e) {
                e.preventDefault();
                axios.post('/', {
                        location: this.location
                    })
                    .then(response => {
                        this.location = response.data[1];
                        // get daily forecast and store for filtering
                        this.daily = response.data[0].data;
                        // assign today to child for first render
                        this.child = this.daily[0];
                        // set icon
                        this.icon = this.child['icon'];
                        //force update on child components
                        this.componentKey += 1;
                    })
            }
        }
    };

</script>

<style scoped>
    canvas {
        width: 150px;
        height: 150px;
    }

</style>
