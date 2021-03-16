new Vue({
    el: '#app',
    data() {
        return {
            is_online : true,
            username : "",
            password : "",
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
        login(){
            axios
                .post(this.baseUrl() + '/api/user/login.php',{'username' : this.username,'password':this.password})
                .then(response => {
                    if (response.data.error != null){
                        return
                    }
                    if (window.localStorage) {
                        window.localStorage.setItem('session', JSON.stringify(response.data.data))
                        window.location = this.baseUrl() + "/home.html"
                    }
                })
                .catch(errors => {
                    console.log(errors)
                }) 
        },
        loadSession(){
            if (window.localStorage && window.localStorage.getItem('session')) {
                this.admin = JSON.parse(window.localStorage.getItem('session'))
                window.location = this.baseUrl() + "/home.html" 
                return;
            }
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
