<template>
    <main class="main">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <i class="fa fa-align-justify"></i> Notas
                    <button type="button" @click="abrirModal('registrar')" class="btn btn-secondary">
                            <i class="icon-plus"></i>&nbsp;Nuevo
                    </button>
                </div>
                <div class="card-body">
                    <table class="table table-bordered table-striped table-sm">
                        <thead>
                            <tr>
                                <th>Opciones</th>
                                <th>Titulo</th>
                                <th>Contenido</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="notas in arrayNotas" :key="notas.id">
                                <td>
                                    <button type="button" @click="abrirModal('actualizar',notas)" class="btn btn-warning btn-sm">
                                        <i class="icon-pencil"></i>
                                    </button> &nbsp;
                                    <button type="button" class="btn btn-danger btn-sm" @click="eliminarNota(notas.id)">
                                        <i class="icon-trash"></i>
                                    </button>

                                </td>
                                <td v-text="notas.title"></td>
                                <td v-text="notas.content"></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <!--Inicio del modal agregar/actualizar-->
        <div class="modal fade" tabindex="-1" :class="{'mostrar' : modal}" role="dialog" aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true">
            <div class="modal-dialog modal-primary modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" v-text="tituloModal"></h4>
                        <button type="button" class="close" @click="cerrarModal()" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="" method="post" enctype="multipart/form-data" class="form-horizontal">
                            <div class="form-group row">
                                <label class="col-md-3 form-control-label" for="text-input">Título</label>
                                <div class="col-md-9">
                                    <input type="text" v-model="title" class="form-control" placeholder="Título de la nota">
                                    
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 form-control-label" for="email-input">Contenido</label>
                                <div class="col-md-9">
                                    <input type="email" v-model="content" class="form-control" placeholder="Ingrese un contenido">
                                </div>
                            </div>
                            <div v-show="errorNota" class="form-group row div-error">
                                <div class="text-center text-error">
                                    <div v-for="error in errorMostrarMsjNota" :key="error" v-text="error">

                                    </div>
                                </div>
                            </div>

                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" @click="cerrarModal()">Cerrar</button>
                        <button type="button" v-if="tipoAccion==1" class="btn btn-primary" @click="registrarNota()">Guardar</button>
                        <button type="button" v-if="tipoAccion==2" class="btn btn-primary" @click="actualizarNota()">Actualizar</button>
                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
        <!--Fin del modal-->
    </main>
</template>

<script>
    export default {
        data() {
            return {
                nota_id: 0,
                title: '',
                content: '',
                arrayNotas : [],
                modal : 0,
                tituloModal : '',
                tipoAccion : 0,
                errorNota : 0,
                errorMostrarMsjNota : []
            }
        },
        methods: {
            listarNotas(){
                let me = this;
                var url = 'http://quadminds-notes-test.getsandbox.com/notes';
                axios.get(url).then(function (response){
                    var respuesta = response.data;
                    me.arrayNotas = respuesta.data;
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            registrarNota(){
                if (this.validarNota()){
                    return;
                }
                
                let me = this;
                var url = 'http://quadminds-notes-test.getsandbox.com/notes';
                axios.post(url,{
                    'title': this.title,
                    'content': this.content
                }).then(function (response) {
                    me.cerrarModal();
                    me.listarNotas();
                }).catch(function (error) {
                    console.log(error);
                });
            },
            actualizarNota(){
                if (this.validarNota()){
                    return;
                }
                
                let me = this;
                var url = 'http://quadminds-notes-test.getsandbox.com/notes/'+me.nota_id;
                axios.put(url,{
                    'title': me.title,
                    'content': me.content
                }).then(function (response) {
                    me.cerrarModal();
                    me.listarNotas();
                }).catch(function (error) {
                    console.log(error);
                });
                
            },
            eliminarNota(id){
               swal({
                title: 'Esta seguro de eliminar esta nota?',
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Aceptar!',
                cancelButtonText: 'Cancelar',
                confirmButtonClass: 'btn btn-success',
                cancelButtonClass: 'btn btn-danger',
                buttonsStyling: false,
                reverseButtons: true
                }).then((result) => {
                if (result.value) {
                    let me = this;
                    var url = 'http://quadminds-notes-test.getsandbox.com/notes/'+id;
                    axios.delete(url).then(function (response) {
                        me.listarNotas();
                        swal(
                        'Eliminado!',
                        'La nota ha sido eliminada con éxito.',
                        'success'
                        )
                    }).catch(function (error) {
                        console.log(error);
                    });
                    
                    
                } else if (
                    // Read more about handling dismissals
                    result.dismiss === swal.DismissReason.cancel
                ) {
                    
                }
                }) 
            },
            validarNota(){
                this.errorNota=0;
                this.errorMostrarMsjNota =[];

                if (!this.title) this.errorMostrarMsjNota.push("El título de la nota no puede estar vacío.");

                if (this.errorMostrarMsjNota.length) this.errorNota = 1;

                return this.errorNota;
            },
            abrirModal(accion, data = []){
                switch (accion) {
                    case 'registrar':
                    {
                        this.modal = 1;
                        this.tituloModal = 'Registrar Nota';
                        this.title= '';
                        this.content = '';
                        this.tipoAccion = 1;
                        break;
                    }
                    case 'actualizar':
                    {
                        this.modal = 1;
                        this.tituloModal='Actualizar nota';
                        this.tipoAccion = 2;
                        this.nota_id = data['id'];
                        this.title = data['title'];
                        this.content = data['content'];
                        break;
                    }   
                }
            },
            cerrarModal(){
                this.modal=0;
                this.tituloModal='';
                this.title='';
                this.content='';
            }
        },
        mounted() {
            this.listarNotas();
        }
    }
</script>
<style>    
    .modal-content{
        width: 100% !important;
        position: absolute !important;
    }
    .mostrar{
        display: list-item !important;
        opacity: 1 !important;
        position: absolute !important;
        background-color: #3c29297a !important;
    }
    .div-error{
        display: flex;
        justify-content: center;
    }
    .text-error{
        color: red !important;
        font-weight: bold;
    }
</style>