<template>
  <v-container class="fill-height" fluid>
    <v-row align="center" justify="center">
      <v-card class="elevation-12" v-if="$store.state.auth">
        <v-toolbar color="primary" dark flat>
          <v-toolbar-title>Registrar institución</v-toolbar-title>
          <v-spacer></v-spacer>
        </v-toolbar>
        <v-card-text>
          <v-form ref="form" v-model="valido">
            <v-text-field
              v-model="rif"
              :rules="rifRules"
              label="Rif"
              required
            ></v-text-field>
            <v-text-field
              v-model="nombre"
              :rules="nombreRules"
              label="Nombre"
              required
            ></v-text-field>
            <v-autocomplete
              v-model="tipo"
              :items="tipoitems"
              :rules="tipoRules"
              item-text="nombre"
              item-value="id"
              outlined
              dense
              chips
              small-chips
              label="Tipo de institución"
              return-object
            ></v-autocomplete>
            <v-text-field
              v-model="direccion"
              :rules="direcRules"
              label="Dirección"
              required
            ></v-text-field>
            <v-autocomplete
              v-model="parroquia"
              :items="parroquiaitems"
              :rules="parroquiaRules"
              item-text="nombre"
              item-value="id"
              outlined
              dense
              chips
              small-chips
              label="Parroquia"
              return-object
            ></v-autocomplete>
            <v-autocomplete
              v-model="aservicio"
              :items="aservicioitems"
              :rules="aservicioRules"
              item-text="nombre"
              item-value="id"
              outlined
              dense
              chips
              small-chips
              label="Area de servicio"
              return-object
            ></v-autocomplete>
            <v-text-field
              v-model="telf"
              :rules="telfRules"
              label="Teléfono"
              required
            ></v-text-field>
            <v-text-field
              v-model="email"
              :rules="emailRules"
              label="E-mail"
              required
            ></v-text-field>
            <v-autocomplete
              v-model="dependencia"
              :items="depenitems"
              :rules="depenRules"
              item-text="nombre"
              item-value="id"
              outlined
              dense
              chips
              small-chips
              label="Tipo de dependencia"
              return-object
            ></v-autocomplete>
            <v-autocomplete
              v-model="sector"
              :items="sectoritems"
              :rules="sectorRules"
              item-text="nombre"
              item-value="id"
              outlined
              dense
              chips
              small-chips
              label="Tipo de sector"
              return-object
            ></v-autocomplete>
            <v-autocomplete
              v-model="estado"
              :items="estadoitems"
              :rules="estadoRules"
              item-text="nombre"
              item-value="id"
              outlined
              dense
              chips
              small-chips
              label="Tipo de estado"
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
            @click="validar"
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
  name: "regisprog",
  data() {
    return {
      registrar: false,
      valido: false,
      snackbar: false,
      color: "",
      mensaje: "",
      rif: "",
      nombre: "",
      tipo: "",
      tipoitems: [
        { id: "1", nombre: "Organismo" },
        { id: "2", nombre: "Estación de servicio" },
      ],
      direccion: "",
      parroquia: "",
      parroquiaitems: [],
      aservicio: "",
      aservicioitems: [],
      telf: "",
      email: "",
      dependencia: "",
      depenitems: [
        { id: "1", nombre: "Nacional" },
        { id: "2", nombre: "Regional" },
        { id: "3", nombre: "Estadal" },
        { id: "4", nombre: "Municipal" },
      ],
      sector: "",
      sectoritems: [
        { id: "1", nombre: "Público" },
        { id: "2", nombre: "Privado" },
      ],
      estado: "",
      estadoitems: [
        { id: "A", nombre: "Activo" },
        { id: "I", nombre: "Inactivo" },
      ],
      observ: "",
      rifRules: [(v) => !!v || "Debe colocar un rif"],
      nombreRules: [(v) => !!v || "Debe colocar un nombre"],
      tipoRules: [(v) => !!v || "Seleccione un tipo"],
      direcRules: [(v) => !!v || "Debe colocar una dirección"],
      parroquiaRules: [(v) => !!v || "Debe seleccionar una parroquia"],
      aservicioRules: [(v) => !!v || "Debe seleccionar un área"],
      telfRules: [(v) => !!v || "Debe colocar un teléfono"],
      emailRules: [
        (v) => !!v || "El correo es requerido",
        (v) => /.+@.+\..+/.test(v) || "Coloque un correo válido",
      ],
      depenRules: [(v) => !!v || "Seleccione una dependencia"],
      sectorRules: [(v) => !!v || "Seleccione un sector"],
      estadoRules: [(v) => !!v || "Seleccione un sector"],
      observRules: [(v) => v.length <= 250 || "Maximo 250 caracteres"],
    };
  },
  mounted() {
    axios
      .get("./parroquia")
      .then((res) => {
        const crear = res.data.permisosuser.find(
          (el) => el.name === "admin.user.create"
        );
        if (crear) this.registrar = true;
        this.parroquiaitems = res.data.parroq.map((par) => {
          return {
            id: par.id,
            nombre: par.par_nombre,
          };
        });
      })
      .catch((er) => {
        this.color = "red accent-2";
        this.mensaje = er;
        this.snackbar = true;
      });
    axios
      .get("./areaser")
      .then((res) => {
        this.aservicioitems = res.data.areaser.map((ser) => {
          return {
            id: ser.id,
            nombre: ser.aser_nombre,
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
    validar() {
      var datos = {
        inst_rif: this.rif,
        inst_nombre: this.nombre,
        inst_tipo: this.tipo.id,
        inst_direccion: this.direccion,
        inst_telefono: this.telf,
        inst_correo: this.email,
        inst_dependencia: this.dependencia.id,
        inst_sector: this.sector.id,
        inst_estado: this.estado.id,
        inst_observacion: this.observ,
        inst_par_id: this.parroquia.id,
        inst_aser_id: this.aservicio.id,
      };
      //alert(JSON.stringify(datos));
      axios
        .post("./instituregist", datos)
        .then((res) => {
          this.color = "success";
          this.mensaje = res.data.mensaje;
          this.snackbar = true;
          this.rif = "";
          this.nombre = "";
          this.tipo = "";
          this.direccion = "";
          this.telf = "";
          this.email = "";
          this.dependencia = "";
          this.sector = "";
          this.estado = "";
          this.observ = "";
          this.parroquia = "";
          this.aservicio = "";
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