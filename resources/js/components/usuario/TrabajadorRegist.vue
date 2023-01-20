<template>
  <v-container class="fill-height" fluid>
    <v-row align="center" justify="center">
      <v-card class="elevation-12" v-if="$store.state.auth && registrar">
        <v-toolbar color="primary" dark flat>
          <v-toolbar-title>Registrar Trabajador</v-toolbar-title>
          <v-spacer></v-spacer>
        </v-toolbar>
        <v-card-text>
          <v-form ref="form" v-model="valido">
            <v-autocomplete
              v-model="tipotrab"
              :items="tipotrabitems"
              :rules="tipotrabRules"
              item-text="nombre"
              item-value="id"
              outlined
              dense
              chips
              small-chips
              label="Tipo de trabajdor"
              return-object
            ></v-autocomplete>
            <v-autocomplete
              align="center"
              justify="center"
              v-model="insti"
              :items="instiitems"
              :rules="instiRules"
              item-text="nombre"
              item-value="id"
              outlined
              dense
              chips
              small-chips
              label="Seleccione la institución"
              return-object
            ></v-autocomplete>
            <v-autocomplete
              v-model="perso"
              :items="persoitems"
              :rules="persoRules"
              item-text="nombre"
              item-value="id"
              outlined
              dense
              chips
              small-chips
              label="Seleccione al personal"
              return-object
            ></v-autocomplete>
            <v-textarea
              counter
              label="Observación"
              :rules="observRules"
              v-model="observ"
            ></v-textarea>
          </v-form>
        </v-card-text>
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn
            v-if="registrar"
            :disabled="!valido"
            color="primary"
            class="mr-4"
            @click="guardar()"
          >
            Registrar
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
  name: "trabajadorregist",
  data() {
    return {
      data: "",
      registrar: false,
      valido: false,
      snackbar: false,
      color: "",
      mensaje: "",
      tipotrab: "",
      tipotrabitems: [
        { id: "1", nombre: "Empleado" },
        { id: "2", nombre: "Directivo" },
        { id: "3", nombre: "Enlace" },
      ],
      tipotrabRules: [(v) => !!v || "Debe el tipo de trabajador"],
      insti: "",
      instiRules: [(v) => !!v || "Seleccione una institución"],
      instiitems: [],
      perso: "",
      persoRules: [(v) => !!v || "Seleccione una institución"],
      persoitems: [],
      observ: "",
      observRules: [(v) => v.length <= 250 || "Maximo 250 caracteres"],
    };
  },
  mounted() {
    axios
      .get("./trabajador")
      .then((res) => {
        //this.data = res.data;
        const crear = res.data.permisosuser.find(
          (el) => el.name === "trab.user.create"
        );
        if (crear) this.registrar = true;
        this.instiitems = res.data.instituciones.map((insti) => {
          return {
            id: insti.id,
            nombre: insti.inst_nombre,
          };
        });
        this.persoitems = res.data.personas.map((pers) => {
          return {
            id: pers.id,
            nombre:
              pers.pers_cedula +
              " " +
              pers.pers_nombres +
              " " +
              pers.pers_apellidos,
          };
        });
      })
      .catch((er) => {
        this.color = "red accent-2";
        this.mensaje = er;
        this.snackbar = true;
      });
  },
  methods: {
    guardar() {
      const envio = {
        trab_tipo_trabajador: this.tipotrab.id,
        trab_estado: "A",
        trab_observacion: this.observ,
        trab_inst_id: this.insti.id,
        trab_pers_id: this.perso.id,
      };
      //alert(JSON.stringify(datos));
      axios
        .post("./trabregist", envio)
        .then((res) => {
          this.color = "success";
          this.mensaje = res.data.mensaje;
          this.snackbar = true;
          this.tipotrab = "";
          this.observ = "";
          this.insti = "";
          this.perso = "";
          this.$refs.form.resetValidation();
          //window.location.reload();
        })
        .catch((er) => {
          this.mensaje = er.response.data.mensaje;
          this.color = "red accent-2";
          this.snackbar = true;
        });
    },
  },
};
</script>