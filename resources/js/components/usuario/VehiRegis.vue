<template>
  <v-container class="fill-height" fluid>
    <v-row align="center" justify="center">
      <v-card class="elevation-12" v-if="$store.state.auth && registrar">
        <v-toolbar color="primary" dark flat>
          <v-toolbar-title>Registrar Vehículos</v-toolbar-title>
          <v-spacer></v-spacer>
        </v-toolbar>
        <v-card-text>
          <v-form ref="form" v-model="valido">
            <v-text-field
              v-model="placa"
              :rules="placaRules"
              label="Placa"
              required
            ></v-text-field>
            <v-text-field
              v-model="tag"
              :rules="tagRules"
              label="Tag"
              required
            ></v-text-field>
            <v-autocomplete
              v-model="tipove"
              :items="tipoveitems"
              :rules="tipoveRules"
              item-text="nombre"
              item-value="id"
              outlined
              dense
              chips
              small-chips
              label="Tipo de vehículo"
              return-object
            ></v-autocomplete>
            <v-autocomplete
              align="center"
              justify="center"
              v-model="modelo"
              :items="modeloitems"
              :rules="modeloRules"
              item-text="nombre"
              item-value="id"
              outlined
              dense
              chips
              small-chips
              label="Modelo"
              return-object
            ></v-autocomplete>
            <v-autocomplete
              v-model="combus"
              :items="combusitems"
              :rules="combusRules"
              item-text="nombre"
              item-value="id"
              outlined
              dense
              chips
              small-chips
              label="Tipo de combustible"
              return-object
            ></v-autocomplete>
            <v-text-field
              v-model="litros"
              :counter="4"
              :rules="litrosRules"
              max="9999"
              type="number"
              label="Litros"
              required
            ></v-text-field>
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
  name: "vehiregis",
  data() {
    return {
      data: "",
      registrar: false,
      valido: false,
      snackbar: false,
      color: "",
      mensaje: "",
      placa: "",
      placaRules: [(v) => !!v || "Debe colocar una placa"],
      tag: "",
      tagRules: [(v) => !!v || "Debe colocar el tag"],
      tipoveitems: [
        { id: "1", nombre: "Automóvil" },
        { id: "2", nombre: "Motocicletaa" },
      ],
      tipove: "",
      tipoveRules: [(v) => !!v || "Seleccione un Tipo de vehíuclo"],
      modeloitems: [],
      modelo: "",
      modeloRules: [(v) => !!v || "Seleccione un modelo"],
      combusitems: [
        { id: "1", nombre: "Gasolina" },
        { id: "2", nombre: "Gasoil" },
      ],
      combus: "",
      combusRules: [(v) => !!v || "Seleccione un Tipo de Combustible"],
      litros: "",
      litrosRules: [
        (v) => !!v || "Seleccione cantidad de litros",
        (v) => v.length > 0 || "Seleccione cantidad de litros",
        (v) => v <= 9999 || "cantidad maxima 9999",
        (v) => v > 0 || "cantidad de litros debe ser mayor a cero",
      ],
      observ: "",
      observRules: [(v) => v.length <= 250 || "Maximo 250 caracteres"],
    };
  },
  mounted() {
    axios
      .get("./persoymodel")
      .then((res) => {
        //this.data = res.data;
        const crear = res.data.permisosuser.find(
          (el) => el.name === "vehi.user.create"
        );
        if (crear) this.registrar = true;
        this.modeloitems = res.data.modelos.map((mode) => {
          return {
            id: mode.id,
            nombre: mode.mod_nombre,
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
        vehi_placa: this.placa.toUpperCase(),
        vehi_tag: this.tag,
        vehi_tipo_vehi: this.tipove.id,
        vehi_tipo_comb: this.combus.id,
        vehi_capacidad_Lts: this.litros,
        vehi_estado: "A",
        vehi_observacion: this.observ,
        vehi_mod_id: this.modelo.id,
        vehi_pers_id: "1",
      };
      //alert(JSON.stringify(datos));
      axios
        .post("./vehiregist", envio)
        .then((res) => {
          this.color = "success";
          this.mensaje = res.data.mensaje;
          this.snackbar = true;
          this.placa = "";
          this.tag = "";
          this.tipove = "";
          this.modelo = "";
          this.combus = "";
          this.litros = "";
          this.observ = "";

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