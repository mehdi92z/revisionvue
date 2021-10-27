<template>
    <div class="container">
    
        <ul class="list-group">
            <li class="list-group-item">mehdi</li>
            <li class="list-group-item" v-for="task in tasks.data " :key='task.id '>
                {{task.name}}
                <button class="btn btn-danger" @click="deleteTask(task.id)" type="button" style="float:right"  >x</button> 
            </li>
            <button class="btn btn-success" @click='showform' type="button">add Task</button>
        </ul>
        <pagination :data="tasks" @pagination-change-page="getResults"></pagination>
        <hr>
        <div class="row" v-if="form" >
            <form class="form" action="">
                <label for="name" class="form form-control">
                    Name:
                </label>
                <input v-model="name"  type="text" class="form form-control" name="name" id="name">
                <br>
                <label for="description" class="form form-control">
                    Description:
                </label>
                <input  v-model="description" type="text" class="form form-control" name="description" id="description">
                
                <br>
                <button class="btn btn-success" type="button" @click="addTask">Add</button>
                
                <button class="btn btn-danger" type="button" @click="showform">Close</button>
            </form>
        </div>
        
    </div>
</template>

<script>
    export default {
        data() {
            return {
                tasks : {},
                form : false,
                name : '',
                description:'' ,
            } 
        },
        created () {
            // axios.get('http://127.0.0.1:8000/tasks')
            // .then(response => this.tasks = response.data )
            // .catch()

        },
        methods: {
            getResults(page = 1) {
			axios.get('http://127.0.0.1:8000/tasks?page=' + page)
				.then(response => {
					this.tasks = response.data;
				});
		    },
            showform() {
                if(this.form){
                    this.form=false;
                }else{
                    this.form=true;
                }
            },
            addTask () {
                axios.post('http://127.0.0.1:8000/addtask',{name :  this.name,description : this.description})
                .then(response => {
                    this.name = '';
                    this.description = '';
                    this.getResults();
                    this.form=false;
                    Swal.fire('Saved!', '', 'success')
                    })
                .catch(error => {
                    console.log(error.response)
                    Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: JSON.stringify(error.response.data.errors)
                    })
                })
            },

            deleteTask(id){
                console.log('my niga')
                Swal.fire({
                title: 'Do you want to delete this one?',
                showDenyButton: true,
                showCancelButton: true,
                confirmButtonText: 'Delete',
                denyButtonText: `Dont delete`,
                }).then((result) => {
                /* Read more about isConfirmed, isDenied below */
                if (result.isConfirmed) {
                    axios.post('http://127.0.0.1:8000/delltask',{id :  id})
                    .then(response => {
                        this.tasks = response.data;
                        Swal.fire('Saved!', '', 'success')
                    })
                    
                } else if (result.isDenied) {
                    Swal.fire('Changes are not saved', '', 'info')
                }
                })
                
       
            }
        },
        mounted() {
            console.log('Component mounted.');
            this.getResults();
        },
        computed : {

        }
    }
</script>
