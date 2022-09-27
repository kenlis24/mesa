<template>
  <v-container class="fill-height" fluid v-if="datos">
    <v-row align="center" justify="center">
      <v-card class="elevation-12">
        <v-toolbar color="primary" dark flat>
          <v-toolbar-title>Cambiar clave</v-toolbar-title>
          <v-spacer></v-spacer>
        </v-toolbar>
        <v-card-text>
          <label
            >Nombre
            <span class="d-flex flex-row mb-6"
              ><b>{{ datos.user.name }}</b></span
            ></label
          >
          <v-spacer></v-spacer>
          <label
            >Email
            <span class="d-flex flex-row mb-6"
              ><b>{{ datos.user.email }}</b></span
            ></label
          >

          <v-spacer></v-spacer>
          <v-form ref="form" v-model="valido">
            <v-text-field
              v-model="clave"
              :rules="claveRules"
              :append-icon="mostrarPass ? 'mdi-eye' : 'mdi-eye-off'"
              :type="mostrarPass ? 'text' : 'password'"
              label="Clave"
              required
              @click:append="mostrarPass = !mostrarPass"
            ></v-text-field>

            <v-text-field
              v-model="clave2"
              :rules="claveRules"
              :append-icon="mostrarPass ? 'mdi-eye' : 'mdi-eye-off'"
              :type="mostrarPass ? 'text' : 'password'"
              label="Repita la clave"
              required
              @click:append="mostrarPass = !mostrarPass"
            ></v-text-field>
          </v-form>
        </v-card-text>
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn :disabled="!valido" outlined color="indigo" @click="cambiar()"
            >Cambiar</v-btn
          >
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
  name: "changepass",
  props: ["id"],
  data() {
    return {
      valido: false,
      datos: "",
      snackbar: false,
      mostrarPass: false,
      color: "",
      roles: [],
      mensaje: "",
      nuevosroles: [],
      clave: "",
      clave2: "",
      claveRules: [
        (v) => !!v || "La clave es requerida",
        (v) => v.length >= 8 || "La clave debe tener minimo 8 caracteres",
      ],
    };
  },
  mounted() {
    axios
      .get(`./users/${this.id}/edit`)
      .then((res) => {
        this.datos = res.data;
      })
      .catch((er) => {
        this.datos = er;
      });
  },
  methods: {
    regresar() {
      setTimeout(() => this.$router.push({ name: "users" }), 2800);
    },
    cambiar() {
      var losdatos = {
        password: this.clave,
        password_confirmation: this.clave2,
      };
      const envio = {
        datos: losdatos,
        id: this.id,
      };
      if (this.clave === this.clave2) {
        axios
          .post(`./changepass/${this.id}`, envio)
          .then((res) => {
            this.color = "success";
            this.mensaje = res.data.mensaje;
            this.snackbar = true;
            this.clave = "";
            this.clave2 = "";
            this.$refs.form.resetValidation();
            this.regresar();
          })
          .catch((er) => {
            this.mensaje = er;
            this.color = "red accent-2";
            this.snackbar = true;
          });
      } else {
        this.color = "red accent-2";
        this.mensaje = "La clave deben ser iguales";
        this.snackbar = true;
      }
      //this.$router.push("users");
    },
  },
};
</script>