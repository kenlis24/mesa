<template>
  <v-container class="fill-height" fluid>
    <v-row align="center" justify="center">
      <v-card class="elevation-12" v-if="$store.state.auth">
        <v-toolbar color="primary" dark flat>
          <v-toolbar-title>Registrar Rol</v-toolbar-title>
          <v-spacer></v-spacer>
        </v-toolbar>
        <v-card-text>
          <v-form ref="form" v-model="valido">
            <v-text-field
              v-model="nombre"
              label="Nombre"
              required
            ></v-text-field>
          </v-form>
        </v-card-text>
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn
            v-if="$store.state.auth"
            :disabled="!valido"
            color="primary"
            class="mr-4"
            @click="crear"
          >
            Registrar
          </v-btn>
        </v-card-actions>
      </v-card>
    </v-row>
    <v-snackbar
      :timeout="2500"
      v-model="snackbar"
      absolute
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
  name: "registrar-roles",
  data() {
    return {
      valido: false,
      snackbar: false,
      mensaje: "",
      color: "",
      nombre: "",
    };
  },
  methods: {
    crear() {
      var datos = {
        name: this.nombre,
      };
      axios
        .post("./rolesregist", datos)
        .then((res) => {
          this.color = "success";
          this.mensaje = "El rol fue registrado";
          this.snackbar = true;
          this.nombre = "";
        })
        .catch((er) => {
          if (er.toString().includes("500")) this.mensaje = "El rol ya existe ";
          else this.mensaje = "No tienes permisos";
          this.color = "red accent-2";
          this.snackbar = true;
        });
    },
  },
};
</script>