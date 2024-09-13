const api = "http://localhost:8080/vue_php_test/Api.php";

const app = Vue.createApp({
    data() {
        return {
            message: "Vue hola",
            users: [],
            modalCreate: false,
            modalUpdate: false,
            modalDel: false,
            currentUser: {}
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
            fd.append('name', document.getElementById('name').value);
            fd.append('email', document.getElementById('email').value);
            fd.append('imagen', document.getElementById('imagen').files[0]);
            axios.post(api + "?opcion=create", fd)
                .then(function (response) {
                    console.log(response.data);
                    app.getUsers();
                });
        },
        selectUser(user) {
            //copia sin referencia
            console.log("user: ", user);
            app.currentUser = JSON.parse(JSON.stringify(user));
            console.log("current_user: ", app.currentUser);
        },
        updateUser() {
            let fd = new FormData();
            fd.append('idUpdate', app.currentUser.id_usuario);
            fd.append('nameUpdate', document.getElementById('nameUpdate').value);
            fd.append('emailUpdate', document.getElementById('emailUpdate').value);
            fd.append('imagenUpdate', document.getElementById('imagenUpdate').files[0]);

            axios.post(api + "?opcion=update", fd)
                .then(function (response) {
                    console.log(response.data);
                    app.currentUser = {};
                    app.getUsers();
                });
        },
        deleteUser(user) {
            let fd = new FormData();
            fd.append('idUpdate', app.currentUser.id_usuario);

            axios.post(api + "?opcion=delete", fd)
                .then(function (response) {
                    if (response.data.success) {
                        app.currentUser = {};
                        app.getUsers();
                    }
                });
        }
    }
}).mount("#app");