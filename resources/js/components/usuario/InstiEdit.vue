<template>
  <v-container class="fill-height" fluid>
    <v-row align="center" justify="center">
      <v-card class="elevation-12" v-if="$store.state.auth">
        <v-toolbar color="primary" dark flat>
          <v-toolbar-title>Editar Instituto</v-toolbar-title>
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
            :disabled="!valido"
            color="primary"
            class="mr-4"
            @click="validar"
          >
            Actualizar
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
  name: "editinstituto",
  props: ["id"],
  data() {
    return {
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
      .get(`./institu/${this.id}/edit`)
      .then((res) => {
        this.parroquiaitems = res.data.parroq.map((par) => {
          return {
            id: par.id,
            nombre: par.par_nombre,
          };
        });
        this.aservicioitems = res.data.areaser.map((aser) => {
          return {
            id: aser.id,
            nombre: aser.aser_nombre,
          };
        });
        res.data.insti.map((inst) => {
          this.rif = inst.inst_rif;
          this.nombre = inst.inst_nombre;
          this.tipo = this.tipoitems.find((el) => {
            if (el.id === inst.inst_tipo) {
              return {
                id: el.id,
                name: el.nombre,
              };
            }
          });

          this.direccion = inst.inst_direccion;

          this.parroquia = res.data.parroq.find((el) => {
            if (el.id === inst.inst_par_id) {
              return {
                id: el.id,
                name: el.inst_nombre,
              };
            }
          });

          this.aservicio = res.data.areaser.find((el) => {
            if (el.id === inst.inst_aser_id) {
              return {
                id: el.id,
                name: el.inst_nombre,
              };
            }
          });

          this.telf = inst.inst_telefono;
          this.email = inst.inst_correo;

          this.dependencia = this.depenitems.find((el) => {
            if (el.id === inst.inst_dependencia) {
              return {
                id: el.id,
                name: el.nombre,
              };
            }
          });

          this.sector = this.sectoritems.find((el) => {
            if (el.id === inst.inst_sector) {
              return {
                id: el.id,
                name: el.nombre,
              };
            }
          });

          this.estado = this.estadoitems.find((el) => {
            if (el.id === inst.inst_estado) {
              return {
                id: el.id,
                name: el.nombre,
              };
            }
          });

          this.observ = inst.inst_observacion;
        });
      })
      .catch((er) => {
        this.color = "red accent-2";
        this.mensaje = "Error al cargar los datos";
        this.snackbar = true;
      });
  },
  methods: {
    regresar() {
      setTimeout(() => this.$router.push({ name: "indexinsti" }), 2800);
    },
    validar() {
      var actualiza = {
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
      axios
        .put(`./institu/${this.id}`, actualiza)
        .then((res) => {
          this.color = "success";
          this.mensaje = res.data.mensaje;
          this.snackbar = true;
          this.regresar();
        })
        .catch((er) => {
          this.color = "red accent-2";
          this.mensaje = er;
          this.snackbar = true;
        });
    },
  },
};
</script>
