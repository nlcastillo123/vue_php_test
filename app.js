const api = "http://localhost/vue_php/api.php";

const app = Vue.createApp({
    data() {
        return {
            message: "Vue hola",
            users: [],
            modalCreate: false
        }
    },
    mounted() {
        this.getUsers()
    },
    methods: {
        getUsers() {
            axios.get(api + "?opcion=list")
                .then(function (response) {
                    console.log(response.data.users);
                    app.users = response.data.users;
                });
        },
        insertUser() {
            let fd = new FormData();
            fd.append('name', document.getElementById('name'));
            fd.append('email', document.getElementById('email'));
            fd.append('email', document.getElementById('email'));
        }
    }
}).mount("#app");