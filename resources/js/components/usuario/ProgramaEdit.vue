<template>
  <v-container class="fill-height" fluid>
    <v-row align="center" justify="center">
      <v-card class="elevation-12" v-if="$store.state.auth">
        <v-toolbar color="primary" dark flat>
          <v-toolbar-title>Editar Programación</v-toolbar-title>
          <v-spacer></v-spacer>
        </v-toolbar>
        <v-card-text>
          <v-form ref="form" v-model="valido">
            <v-autocomplete
              v-model="insti"
              :items="institems"
              :rules="instiRules"
              item-text="nombre"
              item-value="id"
              outlined
              dense
              chips
              small-chips
              label="Institución"
              return-object
            ></v-autocomplete>

            <v-autocomplete
              v-model="estaser"
              :items="estaseritems"
              :rules="estaserRules"
              item-text="nombre"
              item-value="id"
              outlined
              dense
              chips
              small-chips
              label="Estación de Servicio"
              return-object
            ></v-autocomplete>
            <input type="date" v-model="dateFormatted" />
            <v-select
              v-model="tipo"
              :items="tipoitems"
              :rules="tipoRules"
              item-text="nombre"
              item-value="id"
              label="Tipo Combustible"
              return-object
              required
            ></v-select>
            <v-text-field
              v-model="litros"
              :counter="4"
              :rules="litrosRules"
              max="9999"
              type="number"
              label="Litros"
              required
            ></v-text-field>
            <v-select
              v-model="condi"
              :items="conditems"
              :rules="condiRules"
              item-text="nombre"
              item-value="id"
              label="Condición"
              return-object
              required
            ></v-select>
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
  name: "editprograma",
  props: ["id"],
  data() {
    return {
      datos: "",
      valido: false,
      snackbar: false,
      dateFormatted: "",
      color: "",
      mensaje: "",
      institems: [],
      //estaseritems: [{ id: "1", nombre: "Por actualizar" }],
      estaseritems: [],
      tipoitems: [
        { id: "1", nombre: "Gasolina" },
        { id: "2", nombre: "Gasoil" },
      ],
      conditems: [
        { id: "1", nombre: "Creado" },
        { id: "2", nombre: "Programado" },
        { id: "3", nombre: "Aprobado" },
        { id: "4", nombre: "Negado" },
      ],
      insti: "",
      estaser: "",
      tipo: "",
      litros: "",
      condi: "",
      observ: "",
      instiRules: [(v) => !!v || "Seleccione una institución"],
      estaserRules: [(v) => !!v || "Seleccione una estación"],
      tipoRules: [(v) => !!v || "Seleccione un combustible"],
      condiRules: [(v) => !!v || "Seleccione una condición"],
      observRules: [(v) => v.length <= 250 || "Maximo 250 caracteres"],
      litrosRules: [
        (v) => !!v || "Seleccione cantidad de litros",
        (v) => v <= 9999 || "cantidad maxima 9999",
        (v) => v > 0 || "cantidad de litros debe ser mayor a cero",
      ],
    };
  },
  mounted() {
    axios
      .get(`./programa/${this.id}/edit`)
      .then((res) => {
        this.datos = res.data;
        this.institems = res.data.insti.map((inst) => {
          return {
            id: inst.id,
            nombre: inst.inst_nombre,
          };
        });
        this.estaseritems = res.data.estacion.map((inst) => {
          return {
            id: inst.id,
            nombre: inst.inst_nombre,
          };
        });

        this.programa = res.data.progra.map((prog) => {
          this.insti = res.data.insti.find((el) => {
            if (el.id === prog.prog_inst_id) {
              return {
                id: el.id,
                name: el.inst_nombre,
              };
            }
          });

          this.estaser = res.data.estacion.find((el) => {
            if (el.id === prog.prog_inst_id_es) {
              return {
                id: el.id,
                name: el.inst_nombre,
              };
            }
          });

          var quetipo = "";
          if (prog.prog_condicion == 1)
            quetipo = { id: prog.prog_condicion, nombre: "Creado" };
          if (prog.prog_condicion == 2)
            quetipo = { id: prog.prog_condicion, nombre: "Programado" };
          if (prog.prog_condicion == 3)
            quetipo = { id: prog.prog_condicion, nombre: "Aprobado" };
          if (prog.prog_condicion == 4)
            quetipo = { id: prog.prog_condicion, nombre: "Negado" };

          this.dateFormatted = prog.prog_fecha.slice(0, 10);
          this.fecha = this.dateFormatted;
          this.tipo =
            prog.prog_tipo_comb == 1
              ? { id: prog.prog_tipo_comb, nombre: "Gasolina" }
              : { id: prog.prog_tipo_comb, nombre: "Gasoil" };
          this.litros = parseInt(prog.prog_lts);
          this.condi = quetipo;
          this.observ = prog.prog_observacion;
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
      setTimeout(() => this.$router.push({ name: "indexprogra" }), 2800);
    },
    validar() {
      var actualiza = {
        prog_fecha: this.dateFormatted,
        prog_tipo_comb: this.tipo.id,
        prog_lts: this.litros,
        prog_condicion: this.condi.id,
        prog_observacion: this.observ,
        prog_inst_id: this.insti.id.toString(),
        prog_inst_id_es: this.estaser.id,
      };
      axios
        .put(`./programa/${this.id}`, actualiza)
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
      //this.$router.push("users");
    },
  },
};
</script>
