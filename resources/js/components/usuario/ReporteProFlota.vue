<template>
  <v-container class="fill-height" fluid>
    <v-row align="center" justify="center">
      <v-card class="elevation-12" v-if="$store.state.auth">
        <v-toolbar color="primary" dark flat>
          <v-toolbar-title>Fecha y Estación de Programación</v-toolbar-title>
          <v-spacer></v-spacer>
        </v-toolbar>
        <v-card-text>
          <v-form ref="form" v-model="valido">
            <v-autocomplete
              v-model="fecha"
              :items="datositems"
              item-text="prog_fecha"
              item-value="prog_fecha"
              outlined
              dense
              chips
              small-chips
              label="Fecha de programación"
              return-object
            ></v-autocomplete>
  
          </v-form>
        </v-card-text>
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn outlined color="indigo" @click="enviar()">
            <v-icon dense>mdi-plus</v-icon>
            Generar Reporte
          </v-btn>
        </v-card-actions>
      </v-card>
    </v-row>
    <v-snackbar
      bottom
      :timeout="2500"
      v-model="snackbar"
      :color="color"
      rounded="pill"
      right
    >
      {{ this.mensaje }}
    </v-snackbar>
  </v-container>
</template>
<script>
export default {
  name: "reporteproflota",
  data() {
    return {
      registrar: false,
      valido: false,
      snackbar: false,
      color: "",
      mensaje: "",
      fecha: "",
      datositems: [],     
    };
  },
  mounted() {
    axios
      .get("./reporteproflota")
      .then((res) => {
        //this.datos = res.data;

        this.datositems = res.data.progflotrepa.map((prog) => {
                   
          
          return {
            prog_fecha: prog.fecha,            
            prog_nombre: prog.inst_nombre,
          };
        });
        //window.location.reload();
      })
      .catch((er) => {
        this.color = "red accent-2";
        this.mensaje = er;
        this.snackbar = true;
      });
    },
    methods: {
    enviar() {
      this.$router.push({ name: "indexproflotarep", params: { fecha: this.fecha.prog_fecha } });      
    },
  },
  };
</script>