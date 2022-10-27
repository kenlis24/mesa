<template>
  <v-container class="fill-height" fluid>
    <v-col cols="12" sm="6" md="3">
      <v-autocomplete
        align="center"
        justify="center"
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
    </v-col>
    <v-row align="center" justify="center">
      <v-card class="elevation-12" v-if="$store.state.auth && registrar">
        <v-toolbar color="primary" dark flat>
          <v-toolbar-title>Registrar Vehículos</v-toolbar-title>
          <v-spacer></v-spacer>
        </v-toolbar>

        <v-card-text>
          <v-form ref="form" v-model="valido">
            <v-autocomplete
              v-model="persona"
              :items="personaitems"
              :rules="personaRules"
              item-text="nombre"
              item-value="id"
              outlined
              dense
              chips
              small-chips
              label="Persona"
              return-object
            ></v-autocomplete>
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
            @click="asignar()"
          >
            Asignar
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
  name: "indexvehi",
  data() {
    return {
      data: "",
      registrar: false,
      valido: false,
      snackbar: false,
      color: "",
      mensaje: "",
      institems: [],
      insti: "",
      instiRules: [(v) => !!v || "Seleccione una institución"],
      personaitems: [],
      persona: "",
      personaRules: [(v) => !!v || "Seleccione una Persona"],
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
      .get("./institu")
      .then((res) => {
        //this.data = res.data;
        const crear = res.data.permisosuser.find(
          (el) => el.name === "vehi.user.create"
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
    axios
      .get("./persoymodel")
      .then((res) => {
        //this.data = res.data;
        this.modeloitems = res.data.modelos.map((mode) => {
          return {
            id: mode.id,
            nombre: mode.mod_nombre,
          };
        });
        this.personaitems = res.data.personas.map((pers) => {
          return {
            id: pers.id,
            nombre:
              pers.pers_nombres +
              " " +
              pers.pers_apellidos +
              "-" +
              pers.pers_cedula,
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
    asignar() {
      const envio = {
        vehi_placa: this.placa,
        vehi_tag: this.tag,
        vehi_tipo_vehi: this.tipove.id,
        vehi_tipo_comb: this.combus.id,
        vehi_capacidad_Lts: this.litros,
        vehi_estado: "A",
        vehi_observacion: this.observ,
        vehi_pers_id: this.persona.id,
        vehi_mod_id: this.modelo.id,
      };
      alert(JSON.stringify(envio));
      /*var tempo = this.datos.find((element) => element.flo_id == id);
      var litrostemp = this.litros;
      litrostemp += tempo.conp_lts;
      if (litrostemp <= this.litrosasig) {
        this.litros += tempo.conp_lts;
        this.datosasig.push(this.datos.find((element) => element.flo_id == id));
        this.datos = this.datos.filter((item) => item.flo_id !== id);
      } else {
        this.color = "red accent-2";
        this.mensaje =
          "No puedes pasar de los litros asignados a la programación";
        this.snackbar = true;
      }*/
    },
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