new Vue({
    el: '#app',
    data() {
        return {
            is_online : true,
            courses : [],
            query : {
                search_by: "name",
                search_value: "",
                order_by: "name",
                order_dir: "asc",
                offset: 0,
                limit: 10
            },
            host : {
                name : "",
                protocol : "",
                port : ""
            }
        }
    },
    created(){
        window.addEventListener('offline', () => { this.is_online = false })
        window.addEventListener('online', () => { this.is_online = true })
        window.history.pushState({ noBackExitsApp: true }, '')
        window.addEventListener('popstate', this.backPress )
        this.setCurrentHost()
    },
    mounted(){
        this.loadSession()
    },
    methods : {
        loadCourses(){
            axios
                .post(this.baseUrl() + '/api/course/list.php',this.query)
                .then(response => {
                    if (response.data.error != null){
                        return
                    }
                    this.courses = response.data.data
                })
                .catch(errors => {
                    console.log(errors)
                }) 
        },
        toExam(course_id){
            window.location = this.baseUrl() + "/exam.html?course_id=" + course_id; 
        },
        logout(){
            if (window.localStorage.getItem('session')) {
                window.localStorage.removeItem('session')
                window.location = this.baseUrl() + "/index.html" 
            }
        },
        loadSession(){
            if (!window.localStorage.getItem('session')) {
                window.location = this.baseUrl() + "/index.html"
                return;
            }
            this.loadCourses()
        },
        backPress(){
            if (event.state && event.state.noBackExitsApp) {
                window.history.pushState({ noBackExitsApp: true }, '')
            }
        },
        setCurrentHost(){
            this.host.name = window.location.hostname
            this.host.port = location.port
            this.host.protocol = location.protocol.concat("//")
        },
        baseUrl(){
            return this.host.protocol.concat(this.host.name + ":" + this.host.port)
        }
    }
})
