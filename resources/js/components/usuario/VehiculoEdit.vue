<template>
  <v-container class="fill-height" fluid>
    <v-row align="center" justify="center">
      <v-card class="elevation-12" v-if="$store.state.auth && registrar">
        <v-toolbar color="primary" dark flat>
          <v-toolbar-title>Editar Vehículos</v-toolbar-title>
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
  name: "vehiculoedit",
  props: ["id"],
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
        (v) => v <= 9999 || "cantidad maxima 9999",
        (v) => v > 0 || "cantidad de litros debe ser mayor a cero",
      ],
      observ: "",
    };
  },
  mounted() {
    axios
      .get(`./vehiculo/${this.id}/edit`)
      .then((res) => {
        //this.data = res.data;
        const crear = res.data.permisosuser.find(
          (el) => el.name === "vehi.user.edit"
        );
        this.modeloitems = res.data.modelo.map((mode) => {
          return {
            id: mode.id,
            nombre: mode.mod_nombre,
          };
        });
        if (crear) this.registrar = true;
        this.vehiculo = res.data.vehiculo.map((vehi) => {
          this.modelo = res.data.modelo.find((el) => {
            if (el.id === vehi.vehi_mod_id) {
              return {
                id: el.id,
                nombre: el.mod_nombre,
              };
            }
          });
          this.placa = vehi.vehi_placa;
          this.tag = vehi.vehi_tag;
          this.litros = parseInt(vehi.vehi_capacidad_Lts);
          this.observ = vehi.vehi_observacion;
          this.tipove =
            vehi.vehi_tipo_vehi == 1
              ? { id: vehi.vehi_tipo_vehi, nombre: "Automóvil" }
              : { id: vehi.vehi_tipo_vehi, nombre: "Motocicleta" };
          this.combus =
            vehi.vehi_tipo_comb == 1
              ? { id: vehi.vehi_tipo_comb, nombre: "Gasolina" }
              : { id: vehi.vehi_tipo_comb, nombre: "Gasoil" };
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
        vehi_observacion: this.observ,
        vehi_mod_id: this.modelo.id,
      };
      //alert(JSON.stringify(datos));
      axios
        .put(`./vehiupdate/${this.id}`, envio)
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