<template>
    <div class="text-center">
        <h1>Weekly Summary - 
            <span style="text-transform: capitalize;">{{ summary }}</span>
        </h1>  
        <canvas :id="'icon' + this.count" width="150" height="150"></canvas>
        <div class="current">
            <span>{{ temperatureHigh[0] }} <br> {{ temperatureHigh[1] }}</span>       
            <span>{{ temperatureHighTime[0] }} <br> {{ convertTime(temperatureHighTime[1]) }}</span>       
            <span>{{ temperatureLow[0] }} <br> {{ temperatureLow[1] }}</span>    
            <span>{{ temperatureLowTime[0] }} <br> {{ convertTime(temperatureLowTime[1]) }}</span>    
        </div>
    </div>
</template>

<script>
export default {
    props: [
        'weekly', 'count'
    ],
    mounted() {
            //get and set icon
            var skycons = new Skycons({
                color: {
                    sun: "orange"
                }
            });    
            skycons.add(document.getElementById('icon' + this.count), this.weekly.icon);
            skycons.play(); 
        },
    computed: {
        summary() {
            return this.weekly.summary;
        },
        time() {
            return this.weekly.time;
        },
        temperatureHigh() {
            let arr = ["Temperature High"];
            arr.push(this.weekly.temperatureHigh);
            return arr;
        },
        temperatureHighTime() {
            let arr = ["Temperature High Time"];
            arr.push(this.weekly.temperatureHighTime);
            return arr;
        },
        temperatureLow() {
            let arr = ["Temperature Low"];
            arr.push(this.weekly.temperatureLow);
            return arr;
        },
        temperatureLowTime() {
            let arr = ["Temperature Low Time"];
            arr.push(this.weekly.temperatureLowTime);
            return arr;
        },
    },
    methods: {
            convertDate(time) {
                var origDate = new Date(time*1000);
                var months = ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'];
                var year = origDate.getFullYear();
                var month = months[origDate.getMonth()];
                var date = origDate.getDate();
                var formattedDate = date + ' ' + month + ' ' + year + ' ' + hours + ':' + minutes.substr(-2) + ':' + seconds.substr(-2);
                return formattedDate;
            },
            convertTime(time) {
                var origDate = new Date(time*1000);
                var hours = origDate.getHours();
                var minutes = "0" + origDate.getMinutes();
                var seconds = "0" + origDate.getSeconds();
                var formattedTime = hours + ':' + minutes.substr(-2) + ':' + seconds.substr(-2);
                return formattedTime;
            },
            formatTitle(title) {
                return title = title.replace(/([A-Z])/g, ' $1').trim()
            },
            getImage() {
            
            }
        }

}
</script>
