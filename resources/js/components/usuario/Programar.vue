<template>
  <v-container class="fill-height" fluid>
    <v-row align="center" justify="center">
      <v-card class="elevation-12" v-if="$store.state.auth">
        <v-toolbar color="primary" dark flat>
          <v-toolbar-title>Registrar Programaciónes</v-toolbar-title>
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

            <v-text-field
              type="datetime-local"
              v-model="dateFormatted"
              label="Fecha"
              :rules="fechaRules"
              required
            ></v-text-field>

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
            <v-select
              v-model="tipovehi"
              :items="vehiitems"
              :rules="vehiRules"
              item-text="nombre"
              item-value="id"
              label="Tipo Vehículo"
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
            <template>
              <div>Condición</div>
              <div>&nbsp;<strong>Creado</strong></div>
            </template>
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
      data: "",
      registrar: false,
      valido: false,
      snackbar: false,
      dateFormatted: "",
      dateFormatted2: "",
      color: "",
      mensaje: "",
      institems: [],
      estaseritems: [{ id: "1", nombre: "Por actualizar" }],
      tipoitems: [
        { id: "1", nombre: "Gasolina" },
        { id: "2", nombre: "Gasoil" },
      ],
      vehiitems: [
        { id: "1", nombre: "Automóvil" },
        { id: "2", nombre: "Motocicleta" },
      ],
      insti: "",
      estaser: "",
      tipo: "",
      tipovehi: "",
      litros: "",
      condi: "1",
      observ: "",
      instiRules: [(v) => !!v || "Seleccione una institución"],
      estaserRules: [(v) => !!v || "Seleccione una estación"],
      fechaRules: [
        (v) => !!v || "Seleccione una fecha",
        (v) => v.length > 0 || "Seleccione una fecha",
      ],
      tipoRules: [(v) => !!v || "Seleccione un combustible"],
      vehiRules: [(v) => !!v || "Seleccione un tipo de vehículo"],
      condiRules: [(v) => !!v || "Seleccione una condición"],
      observRules: [(v) => v.length <= 250 || "Maximo 250 caracteres"],
      litrosRules: [
        (v) => !!v || "Seleccione cantidad de litros",
        (v) => v.length > 0 || "Seleccione cantidad de litros",
        (v) => v <= 9999 || "cantidad maxima 9999",
        (v) => v > 0 || "cantidad de litros debe ser mayor a cero",
      ],
    };
  },
  mounted() {
    axios
      .get("./institu")
      .then((res) => {
        this.data = res.data;
        const crear = res.data.permisosuser.find(
          (el) => el.name === "program.user.create"
        );
        if (crear) this.registrar = true;
        this.institems = res.data.insti.map((inst) => {
          return {
            id: inst.id,
            nombre: inst.inst_nombre,
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
  watch: {
    dateFormatted: function (val) {
      this.dateFormatted = val.slice(0, 10) + " " + val.slice(11, 16) + ":00";
    },
  },
  methods: {
    validar() {
      var datos = {
        prog_fecha: this.dateFormatted,
        prog_tipo_comb: this.tipo.id,
        prog_lts: this.litros,
        prog_condicion: this.condi,
        prog_tipo_vehi: this.tipovehi.id,
        prog_observacion: this.observ,
        prog_estado: "A",
        prog_inst_id: this.insti.id.toString(),
        prog_inst_id_es: this.estaser.id,
      };

      //alert(JSON.stringify(datos));
      axios
        .post("./programaregist", datos)
        .then((res) => {
          this.color = "success";
          this.mensaje = res.data.mensaje;
          this.snackbar = true;
          this.dateFormatted = "";
          this.tipo = "";
          this.litros = "";
          this.observ = "";
          this.insti = "";
          this.estaser = "";
          this.$refs.form.resetValidation();
          //window.location.reload();
        })
        .catch((er) => {
          this.mensaje = er;
          this.color = "red accent-2";
          this.snackbar = true;
        });
    },
  },
};
</script>