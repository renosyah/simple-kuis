Vue.component('answers', {
    props: ['exam_id'],
    data: function () {
      return {
        submit_status : 0,
        choosed_answer : null,
        answers : [],
        query : {
            search_by: "exam_id",
            search_value: this.exam_id + "",
            order_by: "label",
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
    template : `
    <div>
        <div v-show="answers.length == 0">
            <p>Exam Answer is not found</p>
        </div>
        <p v-for="answer in answers" v-bind:key="answer.id">
            <label>
                <input v-bind:disabled="submit_status == 1" class="with-gap filled-in radio-green" v-bind:name="'group_' + answer.exam_id " type="radio" @click="choosed_answer = answer" v-bind:checked="choosed_answer!= null && choosed_answer.id == answer.id" />
                <span class="black-text">{{ answer.label }}. {{ answer.text }}</span>
            </label>
        </p>
        <button v-show="choosed_answer!= null && submit_status == 0 && answers.length > 0" class="btn btn-small waves-effect waves-light green white-text" @click="submit">
            Submit
        </button>
        <br /><br /><br />
    </div>
    `,
    created(){
        this.setCurrentHost()
    },
    mounted(){
        this.loadExamsAnswer()
    },
    methods : {
        submit(){
            if (!window.localStorage.getItem('session')) {
                return;
            }

            let user = JSON.parse(window.localStorage.getItem('session'))

            let data = {
                "id": 0,
                "exam_id": this.exam_id,
                "exam_answer_id" : this.choosed_answer.id,
                "answer_by": user.id
            }

            axios
                .post(this.baseUrl() + '/api/exam_progress/add.php',data)
                .then(response => {
                    if (response.data.error != null){
                        return
                    }
                    this.submit_status = 1
                    this.can_choose = false
                })
                .catch(errors => {
                    console.log(errors)
                }) 
        },
        loadExamsAnswer(){
            axios
                .post(this.baseUrl() + '/api/exam_answer/list.php',this.query)
                .then(response => {
                    if (response.data.error != null){
                        return
                    }
                    this.answers = response.data.data
                    this.loadExamsAnswered()
                })
                .catch(errors => {
                    console.log(errors)
                }) 
        },
        loadExamsAnswered(){

            if (!window.localStorage.getItem('session')) {
                return;
            }

            let user = JSON.parse(window.localStorage.getItem('session'))

            axios
                .post(this.baseUrl() + '/api/exam_progress/one_answered.php',{exam_id:this.exam_id,answer_by : user.id})
                .then(response => {
                    if (response.data.error != null){
                        return
                    }

                    if (response.data.data == null){
                        return
                    }

                    this.choosed_answer = {
                        "id": response.data.data.exam_answer_id,
                        "exam_id":response.data.data.exam_id,
                        "label": "",
                        "text": ""
                    }
                    
                    this.submit_status = 1
                })
                .catch(errors => {
                    console.log(errors)
                }) 
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


new Vue({
    el: '#app',
    data() {
        return {
            is_online : true,
            exams : [],
            query : {
                search_by: "course_id",
                search_value: "",
                order_by: "number",
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

        let param = new URLSearchParams(window.location.search)
        this.query.search_value = param.get('course_id') + "";

        if (this.query.search_value == "") {
            window.location = this.baseUrl() + "/home.html"
            return;
        }

        this.loadSession()
    },
    methods : {
        loadExams(){
            axios
                .post(this.baseUrl() + '/api/exam/list.php',this.query)
                .then(response => {
                    if (response.data.error != null){
                        return
                    }
                    this.exams = response.data.data
                })
                .catch(errors => {
                    console.log(errors)
                }) 
        },
        toResult(course_id){
            window.location = this.baseUrl() + "/result.html?course_id=" + course_id; 
        },
        loadSession(){
            if (!window.localStorage.getItem('session')) {
                window.location = this.baseUrl() + "/index.html"
                return;
            }
            this.loadExams()
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
