new Vue({
    el: '#app',
    data() {
        return {
            is_online : true,
            image : "",
            file : null,
            course: {
                id: 0,
                name: "",
                description: "",
                image_url: "",
                created_by: 0
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
        uploadImage(){

            if (!window.localStorage.getItem('session')) {
                return;
            }

            let formData = new FormData();
            formData.append('file', this.file);
            axios.post(this.baseUrl() + '/api/upload_file.php', formData, {
                headers: {
                'Content-Type': 'multipart/form-data'
                }
            }).then(response => {
                if (response.data.error != null){
                    return
                }
                this.course.image_url = this.baseUrl() + response.data.data.url
                this.addCourse()
            })
            .catch(errors => {
                console.log(errors)
            }) 
        },
        addCourse(){
            let user = JSON.parse(window.localStorage.getItem('session'))

            this.course.created_by = user.id

            axios
                .post(this.baseUrl() + '/api/course/add.php',this.course)
                .then(response => {
                    if (response.data.error != null){
                        return
                    }
                    window.location = this.baseUrl() + "/course.html"
                })
                .catch(errors => {
                    console.log(errors)
                }) 
        },
        loadSession(){
            if (!window.localStorage.getItem('session')) {
                window.location = this.baseUrl() + "/index.html"
                return;
            }
        },
        onFileChange(e) {
            let files = e.target.files || e.dataTransfer.files
            if (!files.length) return
            this.file = files[0]
            this.createImage(files[0])
        },
        createImage(file) {
            let reader = new FileReader()
            let vm = this
            reader.onload = function(e) {
                vm.image = e.target.result
            }
            reader.readAsDataURL(file)
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
