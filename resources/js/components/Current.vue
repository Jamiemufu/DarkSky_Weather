<template>
    <div class="text-center">
        <h1>Current Summary - 
            <span style="text-transform: capitalize;">{{ summary }}</span>
        </h1>        
        <canvas id="icon" width="150" height="150"></canvas>
        <br><br>
        <div class="current">
            <div class="item" v-for="item, index in current">
                <div v-if="index === 'time'">
                    <span>{{ formatTitle(index) }}</span><br>
                    <span>{{ convertTime(item) }}</span>
                </div>
                <div v-else>
                    <span>{{ formatTitle(index) }}</span><br>
                    <span>{{ item }}</span>
                </div>                
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: [
            "current", "icon", 'summary'
        ],
        created() {        
            //exclude certain properties from response
            var list = [
                "icon", "precipIntensity", "precipProbability", "cloudCover", "uvIndex", 'summary', 'dewPoint'
            ]
            list.forEach(element => {
                Vue.delete(this.current, element);
            });    
        },
        mounted() {
            //get and set icon
            var skycons = new Skycons({
                color: {
                    sun: "orange"
                }
            });    
            skycons.add(document.getElementById("icon"), this.icon);
            skycons.play(); 
        },
        methods: {
            convertTime(time) {
                var date = new Date(time*1000);
                var hours = date.getHours();
                var minutes = "0" + date.getMinutes();
                var seconds = "0" + date.getSeconds();
                var formattedTime = hours + ':' + minutes.substr(-2) + ':' + seconds.substr(-2);
                return formattedTime;
            },
            formatTitle(title) {
                return title = title.replace(/([A-Z])/g, ' $1').trim()
            },
            getImage() {
            
            }
        }
    };
</script>
